<?php

require_once ('admin/acelr_admin.php');

/*
 * acsibr_register_form()
 * Add fields to the registration form
 */

add_action( 'register_form', 'acelr_register_form' );
function acelr_register_form() {

    $first_name = ( ! empty( $_POST['first_name'] ) ) ? trim( $_POST['first_name'] ) : '';
    $last_name = ( ! empty( $_POST['last_name'] ) ) ? trim( $_POST['last_name'] ) : '';

    ?>

    <p>
        <label for="first_name"><?php _e( 'First Name', 'acelr' ) ?><br />
            <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr( wp_unslash( $first_name ) ); ?>" size="25" /></label>
    </p>

    <p>
        <label for="last_name"><?php _e( 'Last Name', 'acelr' ) ?><br />
            <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr( wp_unslash( $last_name ) ); ?>" size="25" /></label>
    </p>

    <?php
}


add_filter( 'registration_errors', 'acelr_registration_errors', 10, 3 );
function acelr_registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
        $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must include a first name.', 'acelr' ) );
    }
    if ( empty( $_POST['last_name'] ) || ! empty( $_POST['last_name'] ) && trim( $_POST['last_name'] ) == '' ) {
        $errors->add( 'last_name_error', __( '<strong>ERROR</strong>: You must include a last name.', 'acelr' ) );
    }
    return $errors;
}



add_action( 'user_register', 'acelr_user_register', 10, 1 );

function acelr_user_register($user_id)
{

    if ( ! empty( $_POST['first_name'] ) ) {
        update_user_meta( $user_id, 'first_name', trim( $_POST['first_name'] ) );
        update_user_meta( $user_id, 'last_name', trim( $_POST['last_name'] ) );
    }

    $user_info = get_userdata($user_id);

    $acelr_user = [];
    $acelr_user['email'] = (isset($_POST['user_email'])) ? $_POST['user_email'] : $user_info->user_email;
    $acelr_user['first_name'] = (isset($_POST['user_first_name'])) ? $_POST['user_first_name'] : $user_info->first_name;
    $acelr_user['last_name'] = (isset($_POST['user_last_name'])) ? $_POST['user_last_name'] : $user_info->last_name;


    if(isset($_POST['register_terms_agree']))
    {
        acelr_send_to_list($acelr_user);
    }else{
        acelr_send_to_list($acelr_user);
    }
    }

function acelr_send_to_list($acelr_user){

    $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', ACSIBR_KEY);

    $apiInstance = new SendinBlue\Client\Api\ContactsApi(new GuzzleHttp\Client(), $credentials);

    $createContact = new \SendinBlue\Client\Model\CreateContact([
        'email' => $acelr_user['email'],
        'updateEnabled' => true,
        'attributes' => (object)[
            'FIRSTNAME' => $acelr_user['first_name'],
            'LASTNAME' => $acelr_user['last_name'],
            'isVIP' => 'true'
        ],
        'listIds' => [
            2
        ]
    ]);

    try
    {
        $result = $apiInstance->createContact($createContact);
        print_r($result);
    } catch (Exception $e)
    {
        echo "<pre>";
        print_r($e);
        echo 'Exception when calling ContactsApi->createContact: ', $e->getMessage(), PHP_EOL;
        echo "</pre>";
    }
}
