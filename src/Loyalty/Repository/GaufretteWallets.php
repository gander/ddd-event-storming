<?php


namespace App\Loyalty\Repository;


use App\Loyalty\Email;
use App\Loyalty\Wallet;
use App\Loyalty\Wallets;
use Gaufrette\Filesystem;

class GaufretteWallets implements Wallets
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function save(Wallet $wallet): void
    {
        $this->filesystem->write($wallet->getEmail()->getAddress(), serialize($wallet), true);
    }

    public function get(Email $email): Wallet
    {
        return unserialize($this->filesystem->read($email->getAddress()));
    }


}
