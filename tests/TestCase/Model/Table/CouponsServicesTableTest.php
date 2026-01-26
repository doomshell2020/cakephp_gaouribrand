<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CouponsServicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CouponsServicesTable Test Case
 */
class CouponsServicesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CouponsServicesTable
     */
    public $CouponsServices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CouponsServices',
        'app.Coupons',
        'app.Services',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CouponsServices') ? [] : ['className' => CouponsServicesTable::class];
        $this->CouponsServices = TableRegistry::getTableLocator()->get('CouponsServices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CouponsServices);

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
