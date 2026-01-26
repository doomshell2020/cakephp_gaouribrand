<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PaymentTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PaymentTypesTable Test Case
 */
class PaymentTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PaymentTypesTable
     */
    public $PaymentTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PaymentTypes',
        'app.Orders',
        'app.Payments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PaymentTypes') ? [] : ['className' => PaymentTypesTable::class];
        $this->PaymentTypes = TableRegistry::getTableLocator()->get('PaymentTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PaymentTypes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
