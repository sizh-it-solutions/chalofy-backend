<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use App\Models\{GeneralSetting};
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class InstallerController extends Controller
{
    public function index()
    {

        return view('installer.index');
    }

    public function requirements()
    {
        $requirements = [
            'php' => version_compare(PHP_VERSION, '8.2', '>='),
            'bcmath' => extension_loaded('bcmath'),
            'ctype' => extension_loaded('ctype'),
            'json' => extension_loaded('json'),
            'mbstring' => extension_loaded('mbstring'),
            'openssl' => extension_loaded('openssl'),
            'pdo' => extension_loaded('pdo'),
            'tokenizer' => extension_loaded('tokenizer'),
            'xml' => extension_loaded('xml'),
            'fileinfo' => extension_loaded('fileinfo'),
            'intl' => extension_loaded('intl'),
            'symlink' => is_callable('symlink') && !in_array('symlink', explode(',', ini_get('disable_functions'))),
        ];

        return view('installer.requirements', compact('requirements'));
    }


    public function permissions()
    {
        $permissions = [
            'storage' => is_writable(storage_path()),
            'bootstrap/cache' => is_writable(app()->bootstrapPath('cache')),
            'config/app.php' => is_writable(config_path('app.php')),
        ];

        return view('installer.permissions', compact('permissions'));
    }

    public function purchaseValidation()
    {


        return view('installer.purchase-validation');
    }


    public function purchaseValidationStore(Request $request)
    {
        $validatedData = $request->validate([
            'coupon_code' => 'required|string|max:255',
        ]);
        $couponCode = $validatedData['coupon_code'];
        $websiteUrl = rtrim(parse_url(url()->current(), PHP_URL_SCHEME) . '://' . parse_url(url()->current(), PHP_URL_HOST), '/');


        $apiUrl = 'https://purchase-validation.unibooker.app/PurchaseValidation/purchase_validation.php';

        $response = Http::post($apiUrl, [
            'coupon_code' => $couponCode,
            'website_url' => $websiteUrl,
        ]);

        $responseBody = $response->json();

        if (isset($responseBody['status']) && $responseBody['status'] === 'success') {

            return redirect()->route('installer.database', ['isValidated' => true]);
        } else {

            return redirect()->route('installer.database', ['isValidated' => false]);
        }
    }

    public function purchaseValidationError()
    {
        return view('installer.purchaseValidation-error');
    }


    public function databaseForm()
    {
        return view('installer.database');
    }

    public function databaseStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'db_host' => 'required',
            'db_port' => 'required|integer',
            'db_name' => 'required',
            'db_username' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('installer.database-error');
        }

        if (self::checkDBConnection($request->db_host, $request->db_name, $request->db_username, $request->db_password, $request->db_port)) {

            $key = base64_encode(random_bytes(32));
            $output = "APP_NAME=uniBooker" . time() . "\n" .
                "APP_ENV=live\n" .
                "APP_KEY=base64:" . $key . "\n" .
                "APP_DEBUG=false\n" .
                "APP_INSTALL=true\n" .
                "APP_LOG_LEVEL=debug\n" .
                "APP_MODE=live\n" .
                "APP_URL=" . URL::to('/') . "\n\n" .

                "DB_CONNECTION=mysql\n" .
                "DB_HOST=" . $request->db_host . "\n" .
                "DB_PORT=3306\n" .
                "DB_DATABASE=" . $request->db_name . "\n" .
                "DB_USERNAME=" . $request->db_username . "\n" .
                "DB_PASSWORD=" . $request->db_password . "\n\n" .

                "BROADCAST_DRIVER=log\n" .
                "CACHE_DRIVER=file\n" .
                "SESSION_DRIVER=file\n" .
                "SESSION_LIFETIME=120\n" .
                "QUEUE_DRIVER=sync\n\n" .

                "REDIS_HOST=127.0.0.1\n" .
                "REDIS_PASSWORD=null\n" .
                "REDIS_PORT=6379\n\n" .

                "PUSHER_APP_ID=\n" .
                "PUSHER_APP_KEY=\n" .
                "PUSHER_APP_SECRET=\n" .
                "PUSHER_APP_CLUSTER=mt1\n\n" .

                "PURCHASE_CODE=" . session('purchase_key') . "\n";

            $file = fopen(base_path('.env'), 'w');
            fwrite($file, $output);
            fclose($file);

            $path = base_path('.env');
            if (file_exists($path)) {

                return redirect()->route('installer.migrate', ['token' => $request['token']]);
            } else {

                return redirect()->route('installer.database-error', ['token' => bcrypt('step_3')]);
            }
        } else {
            return view('installer.database-error');
        }
    }

    public function databaseError()
    {
        return view('installer.database-error');
    }

    public function migrate()
    {
        return view('installer.import-db');

        // Artisan::call('migrate', ['--force' => true]);
        // return redirect()->route('installer.seed');
    }
    public function databaseMigration()
    {
        try {
            Artisan::call('db:wipe', ['--force' => true]);
            $sql_path = base_path('installer/unibooker_vehicle.sql');


            try {
                DB::unprepared(file_get_contents($sql_path));
            } catch (\Exception $e) {

                return $e->getMessage();
            }
            return redirect()->route('installer.admin');
        } catch (\Exception $exception) {
            session()->flash('error', 'Your database is not clean, do you want to clean database then import?');
            return back();
        }
    }
    public function forceMigrate()
    {
        // Optionally run database seeding if needed
        // Artisan::call('db:seed', ['--force' => true]);
        return redirect()->route('installer.admin');
    }

    public function adminForm()
    {

        $modules = DB::table('module')->where('status', 1)->get();

        // Pass the modules to the Blade view
        return view('installer.admin', compact('modules'));
    }

    public function adminStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the administrator user
        $user = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign the 'Admin' role to the user
        $adminRoleId = DB::table('roles')->where('title', 'supper admin')->value('id');
        if ($adminRoleId) {
            DB::table('role_user')->insert([
                'user_id' => $user,
                'role_id' => $adminRoleId,
            ]);
        }

        // $preApp = base_path('config/app.php');
        // $newApp = base_path('installer/app.txt');
        // copy($newApp, $preApp);

        $formData['general_name'] = $request->site_name ?? '';
        $formData['general_email'] = $request->email ?? '';
        $formData['general_phone'] = $request->phone ?? '';
        $formData['general_description'] = $request->general_description ?? '';


        foreach ($formData as $metaKey => $metaValue) {
            if (!empty($metaValue)) {
                GeneralSetting::updateOrCreate(
                    ['meta_key' => $metaKey],
                    ['meta_value' => $metaValue]
                );
            }
        }
        // Optionally save additional information like roles

        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        Artisan::call('cache:clear');
        Artisan::call('key:generate', ['--force' => true]);
        function deleteDirectory($dirPath)
        {
            if (!is_dir($dirPath)) {
                return;
            }

            $files = scandir($dirPath);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..')
                    continue;

                $filePath = $dirPath . DIRECTORY_SEPARATOR . $file;
                is_dir($filePath) ? deleteDirectory($filePath) : unlink($filePath);
            }
            rmdir($dirPath);
        }

        // Remove the storage directory if it exists
        $publicStoragePath = public_path('storage');
        if (is_link($publicStoragePath)) {
            unlink($publicStoragePath);  // If it's a symlink, remove it
        } elseif (is_dir($publicStoragePath)) {
            deleteDirectory($publicStoragePath);  // If it's a directory, delete recursively
        }
        // Create storage link if not exists
        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        return redirect()->route('installer.finish');
    }


    public function finish()
    {


        // File::deleteDirectory(base_path('installer'));
        // File::delete(app_path('Http/Controllers/InstallerController.php'));
        // File::deleteDirectory(resource_path('views/installer'));
        // File::delete(base_path('routes/installer.php'));



        return view('redirect');
    }

    function checkDBConnection($DBHost = "", $DBName = "", $DBUser = "", $DBPass = "", $DBPort = ""): bool
    {
        try {
            if (@mysqli_connect($DBHost, $DBUser, $DBPass, $DBName, $DBPort)) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $exception) {
            return false;
        }
    }
}
