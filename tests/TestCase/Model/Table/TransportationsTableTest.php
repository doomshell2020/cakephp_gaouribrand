<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransportationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransportationsTable Test Case
 */
class TransportationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransportationsTable
     */
    public $Transportations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Transportations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Transportations') ? [] : ['className' => TransportationsTable::class];
        $this->Transportations = TableRegistry::getTableLocator()->get('Transportations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Transportations);

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
