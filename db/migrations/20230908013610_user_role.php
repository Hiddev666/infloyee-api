<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserRole extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $user_role = $this->table('user_role', ['id' => false, 'primary_key' => ['id_role']]);

        $user_role->addColumn('id_role', 'string', ['limit' => 11])
        ->addColumn('role', 'string', ['limit' => 255])
        ->create();
    }
}
