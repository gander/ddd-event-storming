<?php

namespace App\Loyalty\Repository;

use App\Loyalty\Email;
use App\Loyalty\Wallet;
use App\Loyalty\Wallets;
use Webmozart\Assert\Assert;

class SerializedFileWallets implements Wallets
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        Assert::directory($this->path);

        $this->path = $path;
    }

    public function save(Wallet $wallet): void
    {
        $filename = $this->getFilename($wallet->getEmail());

        file_put_contents($filename, serialize($wallet));
    }

    public function get(Email $email): Wallet
    {
        $filename = $this->getFilename($email);

        Assert::fileExists($filename);

        return unserialize(file_get_contents($filename));
    }

    private function getFilename(Email $email)
    {
        return "{$this->path}/{$email->getAddress()}";
    }

}
