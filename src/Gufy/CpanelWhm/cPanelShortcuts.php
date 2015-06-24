<?php namespace Gufy\CpanelWhm;

/**
 * Trait cPanelShortcuts
 *
 * A handful of shortcuts for getting things done(tm)
 *
 * @package Gufy\CpanelWhm
 */
trait cPanelShortcuts {

    /**
     * List all the accounts that the reseller has access to.
     *
     * @return mixed
     */
    public function listAccounts()
    {
        return $this->runQuery('listaccts', []);
    }

    /**
     * Create a new account
     *
     * @param $domain_name
     * @param $username
     * @param $password
     * @param $plan
     *
     * @return mixed
     */
    public function createAccount($domain_name, $username, $password, $plan)
    {
        return $this->runQuery('createacct', [
            'username' => $username,
            'domain' => $domain_name,
            'password' => $password,
            'plan' => $plan,
        ]);
    }

    /**
     * This function deletes a cPanel or WHM account.
     *
     * @param string $username
     */
    public function destroyAccount($username)
    {
        return $this->runQuery('removeacct', [
            'username' => $username,
        ]);
    }

    /**
     * Gets the email addresses that exist under a cPanel account
     *
     * @param $username
     */
    public function listEmailAccounts($username)
    {
        return $this->cpanel('Email', 'listpops', $username);
    }

    /**
     * @param $username **cPanel username**
     * @param $email email address to add
     * @param $password password **for the email address**
     * @return mixed
     * @throws \Exception
     */
    public function addEmailAccount($username, $email, $password)
    {
        list($account, $domain) = $this->split_email($email);

        return $this->emailAcction('addpop', $username, $password, $domain, $account);
    }

    /**
     * Change the password for an email account in cPanel
     * 
     * @param $username
     * @param $email
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function changeEmailPassword($username, $email, $password)
    {
        list($account, $domain) = $this->split_email($email);

        return $this->emailAcction('passwdpop', $username, $password, $domain, $account);
    }

    /**
     * Split an email address into two items, username and host.
     *
     * @param $email
     * @return array
     * @throws \Exception
     */
    private function split_email($email)
    {
        $email_parts = explode('@', $email);
        if (count($email_parts) !== 2) {
            throw new \Exception("Email account is not valid.");
        }

        return $email_parts;
    }

    /**
     * Perform an email action
     *
     * @param $action
     * @param $username
     * @param $password
     * @param $domain
     * @param $account
     * @return mixed
     */
    private function emailAcction($action, $username, $password, $domain, $account)
    {
        return $this->cpanel('Email', $action, $username, [
            'domain' => $domain,
            'email' => $account,
            'password' => $password,
        ]);
    }
}