<?php
require "vendor/autoload.php";

$serviceURL = "https://uat.creditbureau.com.my/scbs/B2BServiceAction.do";
$username = "PCP95450001";
$password = "CBM5021";

try {
    $service = new \MohdNazrul\CBMLaravel\CBMApi($username, $password, $serviceURL);
    $dataArray = [
        'SystemID' => 'SCBS',
        'Service' => 'SMEDTLRPTS',
        'ReportType' => 'CRR-II',
        'MemberID' => 'CP9545',
        'UserID' => 'PCP95450001',
        'ReqNo' => '',
        'SequenceNo' => '001',
        'ReqDate' => '03/04/2018',
        'PurposeStdCode' => 'CREREV',
        'CostCenterStdCode' => '',
        'ConsentFlag' => '',
        'Subject' => [
            'RegNo' => '175481T',
            'RegName' => 'HBM MECHANICAL SERVICES SDN. BHD.',
            'DateBR' => '11/02/1988',
            'ConstitutionTypeStdCode' => '24',
            'BusinessCouCodeStdCode' => '',
            'BusinessStaCodeStdCode' => '',
            'EntityCode' => '4130740',
            'TradeEntityCode' => ''
        ]
    ];

    $xml = $service->generateXMLFromArray($dataArray);

    $res = $service->getReport($xml, false);


//     echo '<pre>'. htmlentities($xml).'</pre>';

//    $res = $service->getReport($xml, true);

//   var_dump( $res );

   print_r($res);

} catch (Exception $e) {
    print_r($e->getMessage());
}
?>