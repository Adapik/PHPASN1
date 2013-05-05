<?php
/*
 * This file is part of PHPASN1 written by Friedrich Große.
 * 
 * Copyright © Friedrich Große, Berlin 2013
 * 
 * PHPASN1 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHPASN1 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHPASN1.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace PHPASN1;

require_once '../external/hexdump.php';
require_once '../classes/PHPASN_Autoloader.php';
PHPASN_Autoloader::register();

function printObject(ASN_Object $object, $depth=0) {
    $treeSymbol = '';
    $depthString = str_repeat('─', $depth);
    if($depth > 0) {
        $treeSymbol = '├';
    }
    
    $name = Identifier::getShortName($object->getType());
    echo "{$treeSymbol}{$depthString}{$name} : ";
    
    echo $object->__toString() . PHP_EOL;
    
    $content = $object->getContent();
    if(is_array($content)) {        
        foreach ($object as $child) {
            printObject($child, $depth+1);
        }
    }    
}

$base64 = "MIIINTCCBh2gAwIBAgIQbVVJc10C7UUjfYRHQ//7nTANBgkqhkiG9w0BAQsFADB0
MQswCQYDVQQGEwJCUjETMBEGA1UEChMKSUNQLUJyYXNpbDEtMCsGA1UECxMkQ2Vy
dGlzaWduIENlcnRpZmljYWRvcmEgRGlnaXRhbCBTLkEuMSEwHwYDVQQDExhBQyBD
ZXJ0aXNpZ24gTXVsdGlwbGEgRzUwHhcNMTIwNTI0MDAwMDAwWhcNMTMwNTIzMjM1
OTU5WjCBwDELMAkGA1UEBhMCQlIxEzARBgNVBAoUCklDUC1CcmFzaWwxIjAgBgNV
BAsUGUF1dGVudGljYWRvIHBvciBBUiBEYXNjaGkxGzAZBgNVBAsUEkFzc2luYXR1
cmEgVGlwbyBBMTEVMBMGA1UECxQMSUQgLSAzMTYzNjAwMRwwGgYDVQQDExNGaW1h
dGVjIFRleHRpbCBMdGRhMSYwJAYJKoZIhvcNAQkBFhdmZXJuYW5kb0BmaW1hdGVj
LmNvbS5icjCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAOqNCGrNF3aV
+lfImn2ji7SsyUbwqyddd2GRnZBUv3lOBQ9DhXq+YX1qjkb/EgGwC9EhIermj3Xw
SZ4PjOweubXAVZ8BY2CrjZhjOOQRq5IKvbqStbsYSEOvOyVfbsDuYdralM6SJpyW
wJRdjTprbKUARU2fJBLJgiGGyIwh0KqAIhp3OcwCW9t4B5RT01fcmPa6hhU808dQ
JgqykA1i8ylQjtXzg52tinUOl6zWZZxxkg5y9l73Lf14eDFHcnI4lFv4kS3jkdk8
mwyll2K0nQX+aMcli8aN3K7C/Lj4VQIWuGarVNfzwg3wP3WzzOS+go0UFZ8ZSy52
3kpfnlsNBK0CAwEAAaOCA3QwggNwMIG6BgNVHREEgbIwga+gPQYFYEwBAwSgNAQy
MjAxMDE5NTkwNTIyNTUzNzg4MDAwMDAwMDAwMDAwMDAwMDAwMDg4NzQzNzJ4c3Nw
U1CgIQYFYEwBAwKgGAQWRmVybmFuZG8gSm9zZSBLYWlyYWxsYaAZBgVgTAEDA6AQ
BA41ODcxNjUyMzAwMDExOaAXBgVgTAEDB6AOBAwwMDAwMDAwMDAwMDCBF2Zlcm5h
bmRvQGZpbWF0ZWMuY29tLmJyMAkGA1UdEwQCMAAwHwYDVR0jBBgwFoAUnVDPvf8k
yq+xM+sX4kJ6jmkqjlMwDgYDVR0PAQH/BAQDAgXgMIGJBgNVHSAEgYEwfzB9BgZg
TAECAQswczBxBggrBgEFBQcCARZlaHR0cDovL2ljcC1icmFzaWwuY2VydGlzaWdu
LmNvbS5ici9yZXBvc2l0b3Jpby9kcGMvQUNfQ2VydGlzaWduX011bHRpcGxhL0RQ
Q19BQ19DZXJ0aVNpZ25NdWx0aXBsYS5wZGYwggElBgNVHR8EggEcMIIBGDBcoFqg
WIZWaHR0cDovL2ljcC1icmFzaWwuY2VydGlzaWduLmNvbS5ici9yZXBvc2l0b3Jp
by9sY3IvQUNDZXJ0aXNpZ25NdWx0aXBsYUc1L0xhdGVzdENSTC5jcmwwW6BZoFeG
VWh0dHA6Ly9pY3AtYnJhc2lsLm91dHJhbGNyLmNvbS5ici9yZXBvc2l0b3Jpby9s
Y3IvQUNDZXJ0aXNpZ25NdWx0aXBsYUc1L0xhdGVzdENSTC5jcmwwW6BZoFeGVWh0
dHA6Ly9yZXBvc2l0b3Jpby5pY3BicmFzaWwuZ292LmJyL2xjci9DZXJ0aXNpZ24v
QUNDZXJ0aXNpZ25NdWx0aXBsYUc1L0xhdGVzdENSTC5jcmwwHQYDVR0lBBYwFAYI
KwYBBQUHAwIGCCsGAQUFBwMEMIGgBggrBgEFBQcBAQSBkzCBkDBkBggrBgEFBQcw
AoZYaHR0cDovL2ljcC1icmFzaWwuY2VydGlzaWduLmNvbS5ici9yZXBvc2l0b3Jp
by9jZXJ0aWZpY2Fkb3MvQUNfQ2VydGlzaWduX011bHRpcGxhX0c1LnA3YzAoBggr
BgEFBQcwAYYcaHR0cDovL29jc3AuY2VydGlzaWduLmNvbS5icjANBgkqhkiG9w0B
AQsFAAOCAgEAyfdKIKDLGZyOhAsycAgJ7RZyn4/2tN29bd+rLwtkvp/9XJGRCAob
fkLU8UACGzbVHT/bB7sOKIiHvp8CgGyoU/1veo5a1yGMFQobQWGcdEYBOd+6Ax6U
FEOc+Ti+LsXsUA5tRbzTwfXJFFOIgFDgrXl7V4JGjSI3GdyoiEECR9OfM/UFYtr/
pD194Xh6G0lSCuP9xOKpOJ7qk24mcfObcGxooMxmktkt0bevzx5w84RtXJfbube+
p6o7JP06T6JJTGfIUfNKYU8wJ6CV9eUHEMDLHMoH6wnYK7d8rHcAbSoTJGMFlSYZ
OqJrWAbKAPjraFNeNaH675u//Ck127kJVidcuRwtkLZV/OIlQaw/4QSp90QWQOQg
AsOWC9+h8v/RcCYTJpWM22MCq3Xk67nz+mXO8e7LKpzHEh2sjX3gkfw4h80zYfT7
kTsNXVdxAHXiIahKNeRUT8fGhxvyOA0RqAXQBUaOyLyGYWRJ7Is5IqAAU6XiBHYe
oJ3v8BTGYzIK2Ud5dZ23yzBp2ejdQzQX1ETpJoEdgELToHmfBXTkI+7ne59wSRkH
beQXoK5y0U3gh1vIz/53GG0QMuCvq9r9xTMERcFJcpQUxJ2RjwxIFHlIFbNwCeiW
I3DmZaXdR169kRoPIqkV3QIREs/yHBvkxXrwDt416stUnQ8KsxAEatE=";

try {
    $binaryData = base64_decode($base64);
    //hexdump($binaryData, false);
    
    $rootObject = ASN_Object::fromBinary($binaryData);
    //printObject($rootObject);
    
    // first navigate to the certificate extensions
    // (see ITU-T X.509 section 7 "Public-keys and public-key certificates" for cert structure)
    assert($rootObject->getType() == Identifier::SEQUENCE);
    $topLevelContainer = $rootObject->getChildren();
    $certificateInfo = $topLevelContainer[0];
    
    assert($certificateInfo->getType() == Identifier::SEQUENCE);
    
    // there need to be at least 8 child elements if the certificate extensions field is present
    assert($certificateInfo->getNumberofChildren() >= 8);
    $certInfoFields = $certificateInfo->getChildren();
    $certExtensions = $certInfoFields[7];
    
    // check if this is really the certificate extensions sequence
    $certExtensionsType = $certExtensions->getType();
    assert(Identifier::isContextSpecificClass($certExtensionsType));
    assert(Identifier::getTagNumber($certExtensions->getType()) == 3);
    
    // this should contain a sequence of extensions 
    $certExtensions = $certExtensions->getFirstChild();
    assert($certExtensions->getType() == Identifier::SEQUENCE);
    
    // now check all extensions and search for the SAN
    foreach ($certExtensions as $extensionSequence) {
    	assert($extensionSequence->getType() == Identifier::SEQUENCE);
        assert($extensionSequence->getNumberofChildren() >= 2);
        
        $extensionSequenceChilds = $extensionSequence->getChildren();
        $objectIdentifier = $extensionSequenceChilds[0];
        assert($objectIdentifier->getType() == Identifier::OBJECT_IDENTIFIER);
        
        if ($objectIdentifier->getContent() == OID::CERT_EXT_SUBJECT_ALT_NAME) {
            // now we have the wanted octet string
            $octetString = $extensionSequenceChilds[1];
            $octetStringBinary = $octetString->getBinaryContent();
                        
            // At this point you may want to create the sequence from the binary value of
            // the octet string and parse its structure like we did so far.
            // However a more general approach would be to understand the format of the 
            // contained SAN fields and implement them in SubjectAlternativeNames.
            $sequence = ASN_Sequence::fromBinary($octetStringBinary);
            echo "This is the parsed content of the SAN certificate extension field so far:" . PHP_EOL;
            printObject($sequence);
            
            // The following does not work yet because PHPASN1 SAn does only support DNS and IP
            //SubjectAlternativeNames::fromBinary($octetStringBinary);
        }
    }
} catch (\Exception $exception) {
    echo '[ERROR] Catched exception:' . PHP_EOL . $exception->getMessage() . PHP_EOL;
}
?>