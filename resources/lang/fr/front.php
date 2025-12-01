<?php

return [

    // General
    'success' => 'Succès',
    'failed' => 'Échec',
    'forbidden' => '403 Interdit.',
    'Validation_error' => 'Erreur de validation.',
    'Internal_Server_Error' => 'Erreur interne du serveur.',
    'api_request_failed' => 'La requête API a échoué.',
    'something_wrong' => 'Une erreur s\'est produite.',
    'ServerError_internal_server_error' => 'Erreur interne du serveur.',
    'Result_found' => 'Résultat trouvé.',
    'token_not_match' => 'Le jeton ne correspond pas.',
    'invalid_token' => 'Jeton invalide.',

    // User / Auth
    'user_not_found' => 'Utilisateur non trouvé.',
    'User_not_found' => 'Utilisateur non trouvé.',
    'user_not_exist' => 'L\'utilisateur n\'existe pas.',
    'user_alredy_exist' => 'L\'utilisateur existe déjà.',
    'user_exist' => 'L\'utilisateur existe.',
    'User_not_register' => 'Utilisateur non enregistré.',
    'account_inactive' => 'Le compte est inactif.',
    'user_deleted_successfully' => 'Utilisateur supprimé avec succès.',
    'update_profile_success' => 'Profil mis à jour avec succès.',
    'profile_image_successfully' => 'Image de profil mise à jour avec succès.',
    'Failed_to_upload_image' => 'Échec du téléchargement de l\'image.',
    'No_image_found_in_the_request' => 'Aucune image trouvée dans la requête.',

    // OTP / Auth flows
    'noOTP_recordFound' => 'Aucun enregistrement OTP trouvé.',
    'OTPhas_expired' => 'L\'OTP a expiré.',
    'OTP_varified' => 'OTP vérifié avec succès.',
    'Incorrect_OTP' => 'OTP incorrect.',
    'Wrong_OTP' => 'OTP erroné.',
    'OTP_sent_successfully' => 'OTP envoyé avec succès.',
    'OTP_resent_succesfully' => 'OTP renvoyé avec succès.',
    'Login_Sucessfully' => 'Connexion réussie.',
    'Logout_Sucessfully' => 'Déconnexion réussie.',
    'RESET_OTP_Found_YOU_CAN_PROCEED' => 'OTP vérifié, vous pouvez continuer.',
    'RESET_OTP_ERROR' => 'OTP invalide.',

    // Password
    'Password_reset_OTP' => 'OTP de réinitialisation de mot de passe envoyé avec succès.',
    'password_Set_error' => 'Erreur lors de la définition du mot de passe.',
    'Password_changed_successfully' => 'Mot de passe modifié avec succès.',
    'password_does_not_match' => 'Le mot de passe ne correspond pas.',
    'new_password_same_as_old' => 'Le nouveau mot de passe ne peut pas être identique à l\'ancien.',
    'password_updated_successfully' => 'Mot de passe mis à jour avec succès.',

    // Email & Phone
    'email_already_exists' => 'L\'email existe déjà.',
    'email_is_not_exists' => 'L\'email n\'existe pas.',
    'email_same_as_current' => 'L\'email est identique à l\'actuel.',
    'email_available_move_OTP_screen' => 'Email disponible, passez à l\'écran OTP.',
    'email_updated_successfully' => 'Email mis à jour avec succès.',
    'Phone_number_is_avilable' => 'Numéro de téléphone disponible.',
    'phone_number_not_exists' => 'Le numéro de téléphone n\'existe pas.',
    'mobile_number_already_exists' => 'Le numéro de mobile existe déjà.',
    'mobile_number_same_as_current' => 'Le numéro de mobile est identique à l\'actuel.',
    'mobile_availabel_move_OTP_screen' => 'Numéro de mobile disponible, passez à l\'écran OTP.',
    'mobile_number_updated_successfully' => 'Numéro de mobile mis à jour avec succès.',

    // Booking
    'booking_not_found_or_not_editable' => 'Réservation non trouvée ou non modifiable.',
    'booking_cancellation_time_limit_exceeded' => 'Délai d\'annulation de la réservation dépassé.',
    'booking_cancelled_successfully' => 'Réservation annulée avec succès.',
    'booking_confirmed_successfully' => 'Réservation confirmée avec succès.',
    'booking_confirmed_time_limit_exceeded' => 'Délai de confirmation de la réservation dépassé.',
    'booking_extension_not_found' => 'Prolongation de réservation non trouvée.',
    'invalid_booking_type' => 'Type de réservation invalide.',
    'booked_succesfully' => 'Réservé avec succès.',
    'please_choose_cancellation_reason' => 'Veuillez choisir une raison d\'annulation.',
    'itemBookingDate' => 'Dates de réservation récupérées avec succès.',
    'bookingpayment' => 'Statut de paiement de la réservation récupéré avec succès.',
    'bookings_fetched' => 'Réservations récupérées avec succès.',
    'upcoming_bookings_is' => 'Réservations à venir récupérées avec succès.',
    'ongoing_bookings_is' => 'Réservations en cours récupérées avec succès.',
    'previous_bookings_is' => 'Réservations précédentes récupérées avec succès.',
    'vendor_upcoming_bookings_is' => 'Réservations à venir du fournisseur récupérées avec succès.',
    'vendor_ongoing_bookings_is' => 'Réservations en cours du fournisseur récupérées avec succès.',
    'vendor_previous_bookings_is' => 'Réservations précédentes du fournisseur récupérées avec succès.',
    'dates_are_not_available' => 'Les dates sélectionnées ne sont pas disponibles.',

    // Wallet
    'Wallet_amount' => 'Montant du portefeuille récupéré avec succès.',
    'vendor_Wallet_amount' => 'Montant du portefeuille du fournisseur récupéré avec succès.',
    'wallet_amount_not_sufficient' => 'Montant du portefeuille insuffisant.',
    'did_not_have_sufficient_balance' => 'Solde insuffisant pour le retrait.',

    // Item
    'item_not_found' => 'Élément non trouvé.',
    'item_added' => 'Élément ajouté avec succès.',
    'item_updated_successfully' => 'Élément mis à jour avec succès.',
    'item_deleted_successfully' => 'Élément supprimé avec succès.',
    'item_not_delivered_yet' => 'Élément non encore livré.',
    'item_delivered_status_updated' => 'Statut de livraison mis à jour avec succès.',
    'item_received_status_updated' => 'Statut de réception mis à jour avec succès.',
    'item_returned_status_updated' => 'Statut de retour mis à jour avec succès.',
    'images_added_successfully' => 'Images ajoutées avec succès.',
    'please_upload_image_after_delete' => 'Veuillez télécharger une image après suppression.',
    'Deleted_successful' => 'Supprimé avec succès.',
    'Failed_to_delete_front_image_Please_try_again_later' => 'Échec de la suppression de l\'image avant. Veuillez réessayer plus tard.',
    'Failed_to_delete_gallery_image_Please_try_again_later' => 'Échec de la suppression de l\'image de la galerie. Veuillez réessayer plus tard.',

    // Wishlist
    'already_exist' => 'L\'élément existe déjà dans la liste de souhaits.',
    'Added_successfully' => 'Ajouté avec succès.',
    'item_not_found_in_wishlist' => 'Élément non trouvé dans la liste de souhaits.',
    'removed_from_wishlist_successfully' => 'Supprimé de la liste de souhaits avec succès.',
    'wishlist_items_fetched_successfully' => 'Articles de la liste de souhaits récupérés avec succès.',

    // Reviews
    'You_must_book_the_item_before_giving_a_review' => 'Vous devez réserver l\'élément avant de laisser un avis.',
    'A_review_already_exists_for_this_booking_guest_item' => 'Un avis existe déjà pour cette réservation, cet invité et cet élément.',
    'Review_created_successfully' => 'Avis créé avec succès.',
    'You_can_only_review_bookings_that_belong_to_you' => 'Vous ne pouvez commenter que vos propres réservations.',
    'A_review_already_exists_for_this_user' => 'Un avis existe déjà pour cet utilisateur.',
    'Review_updated_successfully' => 'Avis mis à jour avec succès.',
    'Reviews_retrieved_successfully' => 'Avis récupérés avec succès.',

    // Notifications
    'emailNotification' => 'Notification par email mise à jour avec succès.',
    'pushNotification' => 'Notification push mise à jour avec succès.',
    'smsNotification' => 'Notification SMS mise à jour avec succès.',
    'emailsmsnotification' => 'Paramètres email et SMS mis à jour avec succès.',
    'fcm_updated_successfully' => 'FCM mis à jour avec succès.',

    // Coupons
    'coupon_code_allready_exists' => 'Le code promo existe déjà.',
    'coupon_added_successfully' => 'Code promo ajouté avec succès.',
    'coupon_code_not_exist' => 'Le code promo n\'existe pas.',

    // Locations
    'yourLocations_found' => 'Emplacements trouvés avec succès.',
    'locations_found' => 'Emplacements trouvés avec succès.',

    // Miscellaneous
    'feedback_added' => 'Retour ajouté avec succès.',
    'currency_rates_updated_successfully' => 'Taux de change mis à jour avec succès.',
    'static_page_data' => 'Données de page statique récupérées avec succès.',
    'slider_data' => 'Données du slider récupérées avec succès.',
    'slider_deleted' => 'Slider supprimé avec succès.',
    'incorrect_page_name' => 'Nom de page incorrect.',
    'Product_not_found' => 'Produit non trouvé.',
    'product_status_updated_successfully' => 'Statut du produit mis à jour avec succès.',
    'dashboard_stats_retrieved_successfully' => 'Statistiques du tableau de bord récupérées avec succès.',
    'bank_account_created_successfully' => 'Compte bancaire créé avec succès.',
    'bank_account_updated_successfully' => 'Compte bancaire mis à jour avec succès.',
    'bank_account_retrieved_successfully' => 'Compte bancaire récupéré avec succès.',
    'bank_account_not_found' => 'Compte bancaire non trouvé.',
    'hostRequest' => 'Demande d\'hôte traitée avec succès.',
    'host_not_found' => 'Hôte non trouvé.',

    // Support Tickets
    'Support_ticket_thread_created_successfully' => 'Fil de ticket de support créé avec succès.',
    'Support_ticket_thread_not_found' => 'Fil de ticket de support non trouvé.',
    'not_have_permission' => 'Vous n\'avez pas la permission d\'effectuer cette action.',
    'Support_ticket_reply_created_successfully' => 'Réponse au ticket de support créée avec succès.',
    'User_threads_retrieved_successfully' => 'Fils utilisateur récupérés avec succès.',
    'Reply_threads_retrieved_successfully' => 'Fils de réponse récupérés avec succès.',
    'You_do_not_have_permission_view_this_thread' => 'Vous n\'avez pas la permission de voir ce fil.',
    'You_do_not_have_permission_close_this_thread' => 'Vous n\'avez pas la permission de fermer ce fil.',
    'support_ticket_closed_successfully' => 'Ticket de support fermé avec succès.',

    // Others
    'Validation_Error' => 'Erreur de validation.',
    'Profile_Retrieved_Successfully' => 'Profil récupéré avec succès.',
    'ItemType_found' => 'Type d\'élément trouvé avec succès.',
    'date_added_successfully' => 'Date(s) ajoutée(s) avec succès.',
    'itemType_found' => 'Type d\'élément trouvé avec succès.',
    'hostRequest' => 'Demande d\'hôte traitée avec succès.',
    'updated_successfully' => 'Mis à jour avec succès.',
    'records_updated' => 'Enregistrements mis à jour et ajoutés.',
    'record_created' => 'Enregistrement créé avec succès.',
    'record_deleted' => 'Enregistrement supprimé avec succès.',
    'validation_failed' => 'La validation a échoué.',
    'not_found' => 'Enregistrement non trouvé.',
    'this_item_is_already_booked' => 'Cet élément est déjà réservé.',

    'steps' => [
        'basic' => 'Informations de base',
        'title' => 'Titre et description',
        'location' => 'Emplacement',
        'features' => 'Caractéristiques',
        'price' => 'Tarification',
        'policies' => 'Politiques',
        'photos' => 'Photos',
        'document' => 'Documents',
        'calendar' => 'Calendrier',
    ],

    'itemType_title_singular' => 'Type d\'élément',
    'feature_title_singular' => 'Caractéristique',
    'item_setting' => 'Paramètres de l\'élément',
    'vehicle_type' => 'Type de véhicule',
    'vehicle_features' => 'Caractéristiques du véhicule',
    'vehicle_setting' => 'Paramètres du véhicule',
    'vehicle_makes' => 'Marques de véhicules',
    'vehicle_model' => 'Modèle de véhicule',

    'save' => 'Sauvegarder',
    'update' => 'Mettre à jour',
    'delete' => 'Supprimer',
    'cancel' => 'Annuler',
    'confirm' => 'Confirmer',

    'validation' => [
        'required' => 'Le champ :attribute est obligatoire.',
        'string' => 'Le champ :attribute doit être une chaîne.',
        'numeric' => 'Le champ :attribute doit être un nombre.',
        'array' => 'Le champ :attribute doit être un tableau.',
        'min' => [
            'array' => 'Le champ :attribute doit contenir au moins :min éléments.',
        ],
    ],

    'attributes' => [
        'id' => 'ID',
        'city' => 'Ville',
        'state' => 'État',
        'address_line_1' => 'Adresse ligne 1',
        'features' => 'Caractéristiques',
        'rules' => 'Règles',
        'start_date' => 'Date de début',
        'end_date' => 'Date de fin',
        'item_id' => 'ID de l\'élément',
        'price' => 'Prix',
        'min_stay' => 'Séjour minimum',
        'status' => 'Statut',
    ],

    'are_you_sure' => 'Êtes-vous sûr ?',
    'action_cannot_be_undone' => 'Cette action est irréversible.',
    'yes_continue' => 'Oui, continuer',
];

