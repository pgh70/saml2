<?php

/**
 * Basic Configuration Wrapper
 */
class SAML2_Configuration_ServiceProvider extends SAML2_Configuration_ArrayAdapter implements
    SAML2_Configuration_CertificateProvider,
    SAML2_Configuration_DecryptionProvider,
    SAML2_Configuration_EntityIdProvider
{
    public function getKeys()
    {
        return $this->get('keys');
    }

    public function getCertificateData()
    {
        return $this->get('certificateData');
    }

    public function getCertificateFile()
    {
        return $this->get('certificateFile');
    }

    public function getCertificateFingerprints()
    {
        return $this->get('certificateFingerprints');
    }

    public function getEntityId()
    {
        return $this->get('entityId');
    }

    public function isAssertionEncrypted()
    {
        return $this->get('assertionEncryptionEnabled');
    }

    /**
     * @return null|string
     */
    public function getSharedKey()
    {
        return $this->get('sharedKey');
    }

    public function getPrivateKey($name = null, $required = false)
    {
        $privateKeys = $this->get('privateKeys');
        $key = array_filter($privateKeys, function (SAML2_Configuration_PrivateKey $key) use ($name) {
            return $key->getName() === $name;
        });

        $keyCount = count($key);
        if ($keyCount !== 1 && $required) {
            throw new \RuntimeException(sprintf(
                'Attempted to get privateKey by name "%s", found "%d" keys, where only one was expected. Please '
                . 'verify that your configuration is correct',
                $name === null ? 'null (default)' : $name,
                $keyCount
            ));
        }

        if (!$keyCount) {
            return null;
        }

        return array_pop($key);
    }
}
