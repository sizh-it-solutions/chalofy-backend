<?php

return [

    // General
    'success' => 'Success',
    'failed' => 'Failed',
    'forbidden' => '403 Forbidden.',
    'Validation_error' => 'Validation error.',
    'Internal_Server_Error' => 'Internal server error.',
    'api_request_failed' => 'API request failed.',
    'something_wrong' => 'Something went wrong.',
    'ServerError_internal_server_error' => 'Internal server error.',
    'Result_found' => 'Result found.',
    'token_not_match' => 'Token does not match.',
    'invalid_token' => 'Invalid token.',

    // User / Auth
    'user_not_found' => 'User not found.',
    'User_not_found' => 'User not found.',
    'user_not_exist' => 'User does not exist.',
    'user_alredy_exist' => 'User already exists.',
    'user_exist' => 'User exists.',
    'User_not_register' => 'User not registered.',
    'account_inactive' => 'Account is inactive.',
    'user_deleted_successfully' => 'User deleted successfully.',
    'update_profile_success' => 'Profile updated successfully.',
    'profile_image_successfully' => 'Profile image updated successfully.',
    'Failed_to_upload_image' => 'Failed to upload image.',
    'No_image_found_in_the_request' => 'No image found in the request.',

    // OTP / Auth flows
    'noOTP_recordFound' => 'No OTP record found.',
    'OTPhas_expired' => 'OTP has expired.',
    'OTP_varified' => 'OTP verified successfully.',
    'Incorrect_OTP' => 'Incorrect OTP.',
    'Wrong_OTP' => 'Wrong OTP.',
    'OTP_sent_successfully' => 'OTP sent successfully.',
    'OTP_resent_succesfully' => 'OTP resent successfully.',
    'Login_Sucessfully' => 'Login successful.',
    'Logout_Sucessfully' => 'Logout successful.',
    'RESET_OTP_Found_YOU_CAN_PROCEED' => 'OTP verified, you can proceed.',
    'RESET_OTP_ERROR' => 'Invalid OTP.',

    // Password
    'Password_reset_OTP' => 'Password OTP sent successfully.',
    'password_Set_error' => 'Error setting password.',
    'Password_changed_successfully' => 'Password changed successfully.',
    'password_does_not_match' => 'Password does not match.',
    'new_password_same_as_old' => 'New password cannot be the same as the old password.',
    'password_updated_successfully' => 'Password updated successfully.',

    // Email & Phone
    'email_already_exists' => 'Email already exists.',
    'email_is_not_exists' => 'Email does not exist.',
    'email_same_as_current' => 'Email is the same as the current one.',
    'email_available_move_OTP_screen' => 'Email available, move to OTP screen.',
    'email_updated_successfully' => 'Email updated successfully.',
    'Phone_number_is_avilable' => 'Phone number is available.',
    'phone_number_not_exists' => 'Phone number does not exist.',
    'mobile_number_already_exists' => 'Mobile number already exists.',
    'mobile_number_same_as_current' => 'Mobile number is the same as the current one.',
    'mobile_availabel_move_OTP_screen' => 'Mobile number available, move to OTP screen.',
    'mobile_number_updated_successfully' => 'Mobile number updated successfully.',

    // Booking
    'booking_not_found_or_not_editable' => 'Booking not found or not editable.',
    'booking_cancellation_time_limit_exceeded' => 'Booking cancellation time limit exceeded.',
    'booking_cancelled_successfully' => 'Booking cancelled successfully.',
    'booking_confirmed_successfully' => 'Booking confirmed successfully.',
    'booking_confirmed_time_limit_exceeded' => 'Booking confirmation time limit exceeded.',
    'booking_extension_not_found' => 'Booking extension not found.',
    'invalid_booking_type' => 'Invalid booking type.',
    'booked_succesfully' => 'Booked successfully.',
    'please_choose_cancellation_reason' => 'Please choose a cancellation reason.',
    'itemBookingDate' => 'Item booking dates retrieved successfully.',
    'bookingpayment' => 'Booking payment status retrieved successfully.',
    'bookings_fetched' => 'Bookings fetched successfully.',
    'upcoming_bookings_is' => 'Upcoming bookings retrieved successfully.',
    'ongoing_bookings_is' => 'Ongoing bookings retrieved successfully.',
    'previous_bookings_is' => 'Previous bookings retrieved successfully.',
    'vendor_upcoming_bookings_is' => 'Vendor upcoming bookings retrieved successfully.',
    'vendor_ongoing_bookings_is' => 'Vendor ongoing bookings retrieved successfully.',
    'vendor_previous_bookings_is' => 'Vendor previous bookings retrieved successfully.',
    'dates_are_not_available' => 'The selected dates are not available.',

    // Wallet
    'Wallet_amount' => 'Wallet amount retrieved successfully.',
    'vendor_Wallet_amount' => 'Vendor wallet amount retrieved successfully.',
    'wallet_amount_not_sufficient' => 'Wallet amount not sufficient.',
    'did_not_have_sufficient_balance' => 'Insufficient balance for withdrawal.',

    // Item
    'item_not_found' => 'Item not found.',
    'item_added' => 'Item added successfully.',
    'item_updated_successfully' => 'Item updated successfully.',
    'item_deleted_successfully' => 'Item deleted successfully.',
    'item_not_delivered_yet' => 'Item not delivered yet.',
    'item_delivered_status_updated' => 'Item delivered status updated successfully.',
    'item_received_status_updated' => 'Item received status updated successfully.',
    'item_returned_status_updated' => 'Item returned status updated successfully.',
    'images_added_successfully' => 'Images added successfully.',
    'please_upload_image_after_delete' => 'Please upload image after delete.',
    'Deleted_successful' => 'Deleted successfully.',
    'Failed_to_delete_front_image_Please_try_again_later' => 'Failed to delete front image. Please try again later.',
    'Failed_to_delete_gallery_image_Please_try_again_later' => 'Failed to delete gallery image. Please try again later.',

    // Wishlist
    'already_exist' => 'Item already exists in wishlist.',
    'Added_successfully' => 'Added successfully.',
    'item_not_found_in_wishlist' => 'Item not found in wishlist.',
    'removed_from_wishlist_successfully' => 'Removed from wishlist successfully.',
    'wishlist_items_fetched_successfully' => 'Wishlist items fetched successfully.',

    // Reviews
    'You_must_book_the_item_before_giving_a_review' => 'You must book the item before giving a review.',
    'A_review_already_exists_for_this_booking_guest_item' => 'A review already exists for this booking, guest, and item.',
    'Review_created_successfully' => 'Review created successfully.',
    'You_can_only_review_bookings_that_belong_to_you' => 'You can only review bookings that belong to you.',
    'A_review_already_exists_for_this_user' => 'A review already exists for this user.',
    'Review_updated_successfully' => 'Review updated successfully.',
    'Reviews_retrieved_successfully' => 'Reviews retrieved successfully.',

    // Notifications
    'emailNotification' => 'Email notification updated successfully.',
    'pushNotification' => 'Push notification updated successfully.',
    'smsNotification' => 'SMS notification updated successfully.',
    'emailsmsnotification' => 'Email and SMS notification settings updated successfully.',
    'fcm_updated_successfully' => 'FCM updated successfully.',

    // Coupons
    'coupon_code_allready_exists' => 'Coupon code already exists.',
    'coupon_added_successfully' => 'Coupon added successfully.',
    'coupon_code_not_exist' => 'Coupon code does not exist.',

    // Locations
    'yourLocations_found' => 'Locations found successfully.',
    'locations_found' => 'Locations found successfully.',

    // Miscellaneous
    'feedback_added' => 'Feedback added successfully.',
    'currency_rates_updated_successfully' => 'Currency rates updated successfully.',
    'static_page_data' => 'Static page data fetched successfully.',
    'slider_data' => 'Slider data fetched successfully.',
    'slider_deleted' => 'Slider deleted successfully.',
    'incorrect_page_name' => 'Incorrect page name.',
    'Product_not_found' => 'Product not found.',
    'product_status_updated_successfully' => 'Product status updated successfully.',
    'dashboard_stats_retrieved_successfully' => 'Dashboard stats retrieved successfully.',
    'bank_account_created_successfully' => 'Bank account created successfully.',
    'bank_account_updated_successfully' => 'Bank account updated successfully.',
    'bank_account_retrieved_successfully' => 'Bank account retrieved successfully.',
    'bank_account_not_found' => 'Bank account not found.',
    'hostRequest' => 'Host request processed successfully.',
    'host_not_found' => 'Host not found.',
    'api_request_failed' => 'API request failed.',

    // Support Tickets
    'Support_ticket_thread_created_successfully' => 'Support ticket thread created successfully.',
    'Support_ticket_thread_not_found' => 'Support ticket thread not found.',
    'not_have_permission' => 'You do not have permission to perform this action.',
    'Support_ticket_reply_created_successfully' => 'Support ticket reply created successfully.',
    'User_threads_retrieved_successfully' => 'User threads retrieved successfully.',
    'Reply_threads_retrieved_successfully' => 'Reply threads retrieved successfully.',
    'You_do_not_have_permission_view_this_thread' => 'You do not have permission to view this thread.',
    'You_do_not_have_permission_close_this_thread' => 'You do not have permission to close this thread.',
    'support_ticket_closed_successfully' => 'Support ticket closed successfully.',

    // Others
    'Validation_Error' => 'Validation error.',
    'Profile_Retrieved_Successfully' => 'Profile retrieved successfully.',
    'ItemType_found' => 'Item type found successfully.',
    'date_added_successfully' => 'Date(s) added successfully.',
    'itemType_found' => 'Item type found successfully.',
    'hostRequest' => 'Host request processed successfully.',
    'updated_successfully' => 'Updated successfully.',
    'records_updated' => 'Records updated and added.',
    'record_created' => 'Record created successfully.',
    'record_deleted' => 'Record deleted successfully.',
    'validation_failed' => 'Validation failed.',
    'not_found' => 'Record not found.',

    'steps' => [
        'basic' => 'Basic Information',
        'title' => 'Title & Description',
        'location' => 'Location',
        'features' => 'Features',
        'price' => 'Pricing',
        'policies' => 'Policies',
        'photos' => 'Photos',
        'document' => 'Documents',
        'calendar' => 'Calendar',
    ],

    'itemType_title_singular' => 'Item Type',
    'feature_title_singular' => 'Feature',
    'item_setting' => 'Item Settings',

    'vehicle_type' => 'Vehicle Type',
    'vehicle_features' => 'Vehicle Features',
    'vehicle_setting' => 'Vehicle Settings',
    'vehicle_makes' => 'Vehicle Makes',
    'vehicle_model' => 'Vehicle Model',

    'save' => 'Save',
    'update' => 'Update',
    'delete' => 'Delete',
    'cancel' => 'Cancel',
    'confirm' => 'Confirm',

    'validation' => [
        'required' => 'The :attribute field is required.',
        'string' => 'The :attribute must be a string.',
        'numeric' => 'The :attribute must be a number.',
        'array' => 'The :attribute must be an array.',
        'min' => [
            'array' => 'The :attribute must have at least :min items.',
        ],
    ],

    'attributes' => [
        'id' => 'ID',
        'city' => 'City',
        'state' => 'State',
        'address_line_1' => 'Address Line 1',
        'features' => 'Features',
        'rules' => 'Rules',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'item_id' => 'Item ID',
        'price' => 'Price',
        'min_stay' => 'Minimum Stay',
        'status' => 'Status',
    ],

    'are_you_sure' => 'Are you sure?',
    'action_cannot_be_undone' => 'This action cannot be undone.',
    'yes_continue' => 'Yes, continue',
    'this_item_is_already_booked' => 'This Vehicle is already booked.',

];
