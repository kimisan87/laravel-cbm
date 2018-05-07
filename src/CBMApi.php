<?php
/**
 * API Library for CBM - Credit Bureau Malaysia System reports.
 * User: Mohd Nazrul Bin Mustaffa
 * Date: 03/04/2018
 * Time: 11:16 AM
 */

namespace MohdNazrul\CBMLaravel;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class CBMApi
{
    private $username;
    private $password;
    private $serviceURL;

    public function __construct($username, $password, $serviceUrl)
    {
        $this->username = $username;
        $this->password = $password;
        $this->serviceURL = $serviceUrl;
    }

    public function generateXMLFromArray($data)
    {
        $xmlString = '<Request>';

        foreach ($data as $key => $value) {

            if ($key == 'Subject') {
                $xmlString .= "<$key>";
                foreach ($value as $key2 => $innerValue) {
                    if (!empty($innerValue)) {
                        $xmlString .= "<$key2>$innerValue</$key2>";
                    } else {
                        $xmlString .= "<$key2/>";
                    }
                }
                $xmlString .= "</$key>";

            } elseif ($key == 'InterestParties') {
                $xmlString .= "<$key>";
                foreach ($value as $key3 => $innerValue2) {
                    if (!empty($innerValue2['InterestParty'])) {
                        $xmlString .= "<InterestParty>";
                        foreach ($innerValue2 as $key4 => $innerValue3) {
                            foreach ($innerValue3 as $key5 => $innerValue4) {
                                if (!empty($innerValue4)) {
                                    $xmlString .= "<$key5>$innerValue4</$key5>";
                                } else {
                                    $xmlString .= "<$key5/>";
                                }
                            }

                        }
                        $xmlString .= "</InterestParty>";
                    }
                }
                $xmlString .= "</$key>";
            } else {
                if (!empty($value)) {
                    $xmlString .= "<$key>$value</$key>";
                } else {
                    $xmlString .= "<$key/>";
                }

            }

        }
        $xmlString .= '</Request>';

        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = false;

        $dom->loadXML($xmlString);

        return $dom->saveXML();
    }

    public function getReport($requestXML, $sendXML = true)
    {
        $client = new Client();

        $response = $client->post(
            $this->serviceURL,
            [
                'auth' => [$this->username, $this->password],
                'headers' => [
                    'Content-Type' => 'application/xml',
                    'Accept' => 'application/xml',
                ],
                'verify' => false,
                'body' => $requestXML,
                'debug' => false
            ]
        );

        if ($response->getStatusCode() != 200) {
            return false;
        }
        $xml = simplexml_load_string($response->getBody()->getContents());
        if ($sendXML) {
            return $xml->asXML();
        }
        $json = json_encode($xml);
        $reportData = json_decode($json, TRUE);
        return $reportData;

    }


}