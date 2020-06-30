<?php

namespace App\Tests\Util;

use App\Entity\PiggyBank;
use App\Services\TransactionChecker;
use PHPUnit\Framework\TestCase;

class isAllowedTest extends TestCase
{
    public function testDebit10()
    {
        $pb = new PiggyBank();
        $pb->setBalance(10);
        $type = "debit";
        $amount = 5;
        $transaction = new TransactionChecker();
        $result = $transaction->isAllowed($pb,$type,$amount);
        $this->assertEquals(true,$result);
    }

    public function testDebit5()
    {
        $pb = new PiggyBank();
        $pb->setBalance(5);
        $type = "debit";
        $amount = 10;
        $transaction = new TransactionChecker();
        $result = $transaction->isAllowed($pb,$type,$amount);
        $this->assertEquals(false,$result);
    }

    public function testCredit999()
    {
        $pb = new PiggyBank();
        $pb->setBalance(999);
        $type = "credit";
        $amount = 10;
        $transaction = new TransactionChecker();
        $result = $transaction->isAllowed($pb,$type,$amount);
        $this->assertEquals(false,$result);
    }

    public function testCredit1000()
    {
        $pb = new PiggyBank();
        $pb->setBalance(999);
        $type = "credit";
        $amount = 1;
        $transaction = new TransactionChecker();
        $result = $transaction->isAllowed($pb,$type,$amount);
        $this->assertEquals(true,$result);
    }

}
