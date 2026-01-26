<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeliveryBoysTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeliveryBoysTable Test Case
 */
class DeliveryBoysTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DeliveryBoysTable
     */
    public $DeliveryBoys;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DeliveryBoys',
        'app.Vendors',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DeliveryBoys') ? [] : ['className' => DeliveryBoysTable::class];
        $this->DeliveryBoys = TableRegistry::getTableLocator()->get('DeliveryBoys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DeliveryBoys);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
