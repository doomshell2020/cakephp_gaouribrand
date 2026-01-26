<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SlotsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SlotsTable Test Case
 */
class SlotsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SlotsTable
     */
    public $Slots;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Slots',
        'app.Appointments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Slots') ? [] : ['className' => SlotsTable::class];
        $this->Slots = TableRegistry::getTableLocator()->get('Slots', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Slots);

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
