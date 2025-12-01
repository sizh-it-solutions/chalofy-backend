<?php

return [

    // General
    'success' => 'สำเร็จ',
    'failed' => 'ล้มเหลว',
    'forbidden' => '403 ไม่อนุญาต',
    'Validation_error' => 'เกิดข้อผิดพลาดในการตรวจสอบ',
    'Internal_Server_Error' => 'เกิดข้อผิดพลาดภายในเซิร์ฟเวอร์',
    'api_request_failed' => 'การเรียก API ล้มเหลว',
    'something_wrong' => 'เกิดข้อผิดพลาดบางอย่าง',
    'ServerError_internal_server_error' => 'เกิดข้อผิดพลาดภายในเซิร์ฟเวอร์',
    'Result_found' => 'พบข้อมูล',
    'token_not_match' => 'Token ไม่ตรงกัน',
    'invalid_token' => 'Token ไม่ถูกต้อง',

    // User / Auth
    'user_not_found' => 'ไม่พบผู้ใช้',
    'User_not_found' => 'ไม่พบผู้ใช้',
    'user_not_exist' => 'ผู้ใช้ไม่พบ',
    'user_alredy_exist' => 'ผู้ใช้มีอยู่แล้ว',
    'user_exist' => 'ผู้ใช้มีอยู่',
    'User_not_register' => 'ผู้ใช้ยังไม่ได้ลงทะเบียน',
    'account_inactive' => 'บัญชีถูกปิดใช้งาน',
    'user_deleted_successfully' => 'ลบผู้ใช้เรียบร้อยแล้ว',
    'update_profile_success' => 'อัปเดตโปรไฟล์เรียบร้อยแล้ว',
    'profile_image_successfully' => 'อัปเดตรูปโปรไฟล์เรียบร้อยแล้ว',
    'Failed_to_upload_image' => 'อัปโหลดรูปภาพไม่สำเร็จ',
    'No_image_found_in_the_request' => 'ไม่พบรูปภาพในคำขอ',

    // OTP / Auth flows
    'noOTP_recordFound' => 'ไม่พบข้อมูล OTP',
    'OTPhas_expired' => 'OTP หมดอายุแล้ว',
    'OTP_varified' => 'ยืนยัน OTP สำเร็จ',
    'Incorrect_OTP' => 'OTP ไม่ถูกต้อง',
    'Wrong_OTP' => 'OTP ผิดพลาด',
    'OTP_sent_successfully' => 'ส่ง OTP เรียบร้อยแล้ว',
    'OTP_resent_succesfully' => 'ส่ง OTP อีกครั้งเรียบร้อยแล้ว',
    'Login_Sucessfully' => 'เข้าสู่ระบบสำเร็จ',
    'Logout_Sucessfully' => 'ออกจากระบบสำเร็จ',
    'RESET_OTP_Found_YOU_CAN_PROCEED' => 'ยืนยัน OTP แล้ว สามารถดำเนินการต่อได้',
    'RESET_OTP_ERROR' => 'OTP ไม่ถูกต้อง',

    // Password
    'Password_reset_OTP' => 'ส่ง OTP สำหรับรีเซ็ตรหัสผ่านเรียบร้อยแล้ว',
    'password_Set_error' => 'เกิดข้อผิดพลาดในการตั้งรหัสผ่าน',
    'Password_changed_successfully' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
    'password_does_not_match' => 'รหัสผ่านไม่ตรงกัน',
    'new_password_same_as_old' => 'รหัสผ่านใหม่ไม่สามารถซ้ำกับรหัสเดิมได้',
    'password_updated_successfully' => 'อัปเดตรหัสผ่านเรียบร้อยแล้ว',

    // Email & Phone
    'email_already_exists' => 'อีเมลนี้มีอยู่แล้ว',
    'email_is_not_exists' => 'ไม่พบอีเมลนี้',
    'email_same_as_current' => 'อีเมลนี้ตรงกับอีเมลปัจจุบัน',
    'email_available_move_OTP_screen' => 'อีเมลพร้อมใช้งาน ย้ายไปหน้ากรอก OTP',
    'email_updated_successfully' => 'อัปเดตอีเมลเรียบร้อยแล้ว',
    'Phone_number_is_avilable' => 'หมายเลขโทรศัพท์พร้อมใช้งาน',
    'phone_number_not_exists' => 'ไม่พบหมายเลขโทรศัพท์',
    'mobile_number_already_exists' => 'หมายเลขมือถือมีอยู่แล้ว',
    'mobile_number_same_as_current' => 'หมายเลขมือถือเหมือนกับปัจจุบัน',
    'mobile_availabel_move_OTP_screen' => 'หมายเลขมือถือพร้อมใช้งาน ย้ายไปหน้ากรอก OTP',
    'mobile_number_updated_successfully' => 'อัปเดตหมายเลขมือถือเรียบร้อยแล้ว',

    // Booking
    'booking_not_found_or_not_editable' => 'ไม่พบการจองหรือไม่สามารถแก้ไขได้',
    'booking_cancellation_time_limit_exceeded' => 'เกินระยะเวลาการยกเลิกการจอง',
    'booking_cancelled_successfully' => 'ยกเลิกการจองเรียบร้อยแล้ว',
    'booking_confirmed_successfully' => 'ยืนยันการจองเรียบร้อยแล้ว',
    'booking_confirmed_time_limit_exceeded' => 'เกินระยะเวลาการยืนยันการจอง',
    'booking_extension_not_found' => 'ไม่พบข้อมูลการขยายเวลา',
    'invalid_booking_type' => 'ประเภทการจองไม่ถูกต้อง',
    'booked_succesfully' => 'จองสำเร็จ',
    'please_choose_cancellation_reason' => 'กรุณาเลือกเหตุผลการยกเลิก',
    'itemBookingDate' => 'ดึงวันที่การจองเรียบร้อยแล้ว',
    'bookingpayment' => 'ดึงสถานะการชำระเงินเรียบร้อยแล้ว',
    'bookings_fetched' => 'ดึงข้อมูลการจองเรียบร้อยแล้ว',
    'upcoming_bookings_is' => 'ดึงข้อมูลการจองที่กำลังจะมาถึงเรียบร้อยแล้ว',
    'ongoing_bookings_is' => 'ดึงข้อมูลการจองที่กำลังดำเนินการเรียบร้อยแล้ว',
    'previous_bookings_is' => 'ดึงข้อมูลการจองที่ผ่านมาเรียบร้อยแล้ว',
    'vendor_upcoming_bookings_is' => 'ดึงข้อมูลการจองของผู้ขายที่กำลังจะมาถึงเรียบร้อยแล้ว',
    'vendor_ongoing_bookings_is' => 'ดึงข้อมูลการจองของผู้ขายที่กำลังดำเนินการเรียบร้อยแล้ว',
    'vendor_previous_bookings_is' => 'ดึงข้อมูลการจองของผู้ขายที่ผ่านมาเรียบร้อยแล้ว',
    'dates_are_not_available' => 'วันที่ที่เลือกไม่พร้อมใช้งาน',

    // Wallet
    'Wallet_amount' => 'ดึงจำนวนเงินในวอลเล็ตเรียบร้อยแล้ว',
    'vendor_Wallet_amount' => 'ดึงจำนวนเงินในวอลเล็ตผู้ขายเรียบร้อยแล้ว',
    'wallet_amount_not_sufficient' => 'จำนวนเงินในวอลเล็ตไม่เพียงพอ',
    'did_not_have_sufficient_balance' => 'ยอดเงินไม่เพียงพอสำหรับถอน',

    // Item
    'item_not_found' => 'ไม่พบรายการ',
    'item_added' => 'เพิ่มรายการเรียบร้อยแล้ว',
    'item_updated_successfully' => 'อัปเดตรายการเรียบร้อยแล้ว',
    'item_deleted_successfully' => 'ลบรายการเรียบร้อยแล้ว',
    'item_not_delivered_yet' => 'ยังไม่ได้จัดส่งรายการ',
    'item_delivered_status_updated' => 'อัปเดตสถานะการจัดส่งเรียบร้อยแล้ว',
    'item_received_status_updated' => 'อัปเดตสถานะการรับเรียบร้อยแล้ว',
    'item_returned_status_updated' => 'อัปเดตสถานะการคืนเรียบร้อยแล้ว',
    'images_added_successfully' => 'เพิ่มรูปภาพเรียบร้อยแล้ว',
    'please_upload_image_after_delete' => 'กรุณาอัปโหลดรูปภาพใหม่หลังลบ',
    'Deleted_successful' => 'ลบเรียบร้อยแล้ว',
    'Failed_to_delete_front_image_Please_try_again_later' => 'ลบรูปภาพหน้ารายการไม่สำเร็จ กรุณาลองใหม่ภายหลัง',
    'Failed_to_delete_gallery_image_Please_try_again_later' => 'ลบรูปภาพแกลเลอรี่ไม่สำเร็จ กรุณาลองใหม่ภายหลัง',

    // Wishlist
    'already_exist' => 'รายการนี้มีอยู่แล้วในรายการโปรด',
    'Added_successfully' => 'เพิ่มเรียบร้อยแล้ว',
    'item_not_found_in_wishlist' => 'ไม่พบรายการในรายการโปรด',
    'removed_from_wishlist_successfully' => 'ลบออกจากรายการโปรดเรียบร้อยแล้ว',
    'wishlist_items_fetched_successfully' => 'ดึงรายการโปรดเรียบร้อยแล้ว',

    // Reviews
    'You_must_book_the_item_before_giving_a_review' => 'คุณต้องจองรายการก่อนที่จะให้รีวิว',
    'A_review_already_exists_for_this_booking_guest_item' => 'มีรีวิวสำหรับการจองนี้อยู่แล้ว',
    'Review_created_successfully' => 'สร้างรีวิวเรียบร้อยแล้ว',
    'You_can_only_review_bookings_that_belong_to_you' => 'คุณสามารถรีวิวการจองที่เป็นของคุณเท่านั้น',
    'A_review_already_exists_for_this_user' => 'มีรีวิวสำหรับผู้ใช้นี้อยู่แล้ว',
    'Review_updated_successfully' => 'อัปเดตรีวิวเรียบร้อยแล้ว',
    'Reviews_retrieved_successfully' => 'ดึงรีวิวเรียบร้อยแล้ว',

    // Notifications
    'emailNotification' => 'อัปเดตการแจ้งเตือนอีเมลเรียบร้อยแล้ว',
    'pushNotification' => 'อัปเดตการแจ้งเตือนพุชเรียบร้อยแล้ว',
    'smsNotification' => 'อัปเดตการแจ้งเตือน SMS เรียบร้อยแล้ว',
    'emailsmsnotification' => 'อัปเดตการแจ้งเตือนอีเมลและ SMS เรียบร้อยแล้ว',
    'fcm_updated_successfully' => 'อัปเดต FCM เรียบร้อยแล้ว',

    // Coupons
    'coupon_code_allready_exists' => 'โค้ดคูปองมีอยู่แล้ว',
    'coupon_added_successfully' => 'เพิ่มคูปองเรียบร้อยแล้ว',
    'coupon_code_not_exist' => 'ไม่พบโค้ดคูปอง',

    // Locations
    'yourLocations_found' => 'พบตำแหน่งของคุณเรียบร้อยแล้ว',
    'locations_found' => 'พบตำแหน่งเรียบร้อยแล้ว',

    // Miscellaneous
    'feedback_added' => 'ส่งข้อเสนอแนะเรียบร้อยแล้ว',
    'currency_rates_updated_successfully' => 'อัปเดตอัตราแลกเปลี่ยนเรียบร้อยแล้ว',
    'static_page_data' => 'ดึงข้อมูลหน้าคงที่เรียบร้อยแล้ว',
    'slider_data' => 'ดึงข้อมูลสไลเดอร์เรียบร้อยแล้ว',
    'slider_deleted' => 'ลบสไลเดอร์เรียบร้อยแล้ว',
    'incorrect_page_name' => 'ชื่อหน้าไม่ถูกต้อง',
    'Product_not_found' => 'ไม่พบสินค้า',
    'product_status_updated_successfully' => 'อัปเดตสถานะสินค้าเรียบร้อยแล้ว',
    'dashboard_stats_retrieved_successfully' => 'ดึงสถิติแดชบอร์ดเรียบร้อยแล้ว',
    'bank_account_created_successfully' => 'สร้างบัญชีธนาคารเรียบร้อยแล้ว',
    'bank_account_updated_successfully' => 'อัปเดตบัญชีธนาคารเรียบร้อยแล้ว',
    'bank_account_retrieved_successfully' => 'ดึงข้อมูลบัญชีธนาคารเรียบร้อยแล้ว',
    'bank_account_not_found' => 'ไม่พบบัญชีธนาคาร',
    'hostRequest' => 'ดำเนินการคำขอโฮสต์เรียบร้อยแล้ว',
    'host_not_found' => 'ไม่พบโฮสต์',
    'api_request_failed' => 'การเรียก API ล้มเหลว',

    // Support Tickets
    'Support_ticket_thread_created_successfully' => 'สร้างหัวข้อสนับสนุนเรียบร้อยแล้ว',
    'Support_ticket_thread_not_found' => 'ไม่พบหัวข้อสนับสนุน',
    'not_have_permission' => 'คุณไม่มีสิทธิ์ในการดำเนินการนี้',
    'Support_ticket_reply_created_successfully' => 'สร้างการตอบกลับในหัวข้อสนับสนุนเรียบร้อยแล้ว',
    'User_threads_retrieved_successfully' => 'ดึงหัวข้อของผู้ใช้เรียบร้อยแล้ว',
    'Reply_threads_retrieved_successfully' => 'ดึงหัวข้อการตอบกลับเรียบร้อยแล้ว',
    'You_do_not_have_permission_view_this_thread' => 'คุณไม่มีสิทธิ์ในการดูหัวข้อนี้',
    'You_do_not_have_permission_close_this_thread' => 'คุณไม่มีสิทธิ์ในการปิดหัวข้อนี้',
    'support_ticket_closed_successfully' => 'ปิดหัวข้อสนับสนุนเรียบร้อยแล้ว',

    // Others
    'Validation_Error' => 'เกิดข้อผิดพลาดในการตรวจสอบ',
    'Profile_Retrieved_Successfully' => 'ดึงโปรไฟล์เรียบร้อยแล้ว',
    'ItemType_found' => 'พบประเภทสินค้าเรียบร้อยแล้ว',
    'date_added_successfully' => 'เพิ่มวันที่เรียบร้อยแล้ว',
    'itemType_found' => 'พบประเภทสินค้าเรียบร้อยแล้ว',
    'hostRequest' => 'ดำเนินการคำขอโฮสต์เรียบร้อยแล้ว',
    'updated_successfully' => 'อัปเดตเรียบร้อยแล้ว',
    'records_updated' => 'อัปเดตและเพิ่มข้อมูลเรียบร้อยแล้ว',
    'record_created' => 'สร้างข้อมูลเรียบร้อยแล้ว',
    'record_deleted' => 'ลบข้อมูลเรียบร้อยแล้ว',
    'validation_failed' => 'การตรวจสอบล้มเหลว',
    'not_found' => 'ไม่พบข้อมูล',

    'steps' => [
        'basic' => 'ข้อมูลพื้นฐาน',
        'title' => 'ชื่อและคำอธิบาย',
        'location' => 'ตำแหน่ง',
        'features' => 'คุณสมบัติ',
        'price' => 'ราคา',
        'policies' => 'นโยบาย',
        'photos' => 'รูปภาพ',
        'document' => 'เอกสาร',
        'calendar' => 'ปฏิทิน',
    ],

    'itemType_title_singular' => 'ประเภทสินค้า',
    'feature_title_singular' => 'คุณสมบัติ',
    'item_setting' => 'การตั้งค่าสินค้า',

    'vehicle_type' => 'ประเภทยานพาหนะ',
    'vehicle_features' => 'คุณสมบัติยานพาหนะ',
    'vehicle_setting' => 'การตั้งค่ายานพาหนะ',
    'vehicle_makes' => 'ยี่ห้อยานพาหนะ',
    'vehicle_model' => 'รุ่นยานพาหนะ',

    'save' => 'บันทึก',
    'update' => 'อัปเดต',
    'delete' => 'ลบ',
    'cancel' => 'ยกเลิก',
    'confirm' => 'ยืนยัน',

    'validation' => [
        'required' => 'ฟิลด์ :attribute จำเป็นต้องกรอก',
        'string' => ':attribute ต้องเป็นข้อความ',
        'numeric' => ':attribute ต้องเป็นตัวเลข',
        'array' => ':attribute ต้องเป็นอาเรย์',
        'min' => [
            'array' => ':attribute ต้องมีอย่างน้อย :min รายการ',
        ],
    ],

    'attributes' => [
        'id' => 'รหัส',
        'city' => 'เมือง',
        'state' => 'รัฐ',
        'address_line_1' => 'ที่อยู่บรรทัดที่ 1',
        'features' => 'คุณสมบัติ',
        'rules' => 'กฎ',
        'start_date' => 'วันที่เริ่มต้น',
        'end_date' => 'วันที่สิ้นสุด',
        'item_id' => 'รหัสสินค้า',
        'price' => 'ราคา',
        'min_stay' => 'ระยะเวลาการเข้าพักขั้นต่ำ',
        'status' => 'สถานะ',
    ],

    'are_you_sure' => 'คุณแน่ใจหรือไม่?',
    'action_cannot_be_undone' => 'การดำเนินการนี้ไม่สามารถย้อนกลับได้',
    'yes_continue' => 'ใช่ ดำเนินการต่อ',
    'this_item_is_already_booked' => 'ยานพาหนะนี้ถูกจองแล้ว',

];
