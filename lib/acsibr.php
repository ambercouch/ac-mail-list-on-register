<?php




add_action( 'user_register', 'acsibr_user_register', 10, 1 );

function acsibr_user_register($user_id)
{
    $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', ACSIBR_KEY);

if(isset($_POST['register_terms_agree']))
{


    $apiInstance = new SendinBlue\Client\Api\ContactsApi(new GuzzleHttp\Client(), $credentials);

    $createContact = new \SendinBlue\Client\Model\CreateContact([
        'email' => $_POST['register_email'],
        'updateEnabled' => true,
        'attributes' => (object)[
            'FIRSTNAME' => $_POST['register_first_name'],
            'LASTNAME' => $_POST['register_last_name'],
            'isVIP' => 'true'
        ],
        'listIds' => [
            2,
            5
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
}else{
    return;
}
}
