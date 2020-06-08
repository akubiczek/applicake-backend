<?php


class ExampleFormFields extends \App\Services\TenantSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formFieldsSeeder = new FormFieldsSeeder();
        $formFieldsSeeder->setConnection($this->connection);
        $recruitments = \App\Models\Recruitment::get();

        foreach ($recruitments as $recruitment) {
            $formFieldsSeeder->setRecruitment($recruitment);
            $formFieldsSeeder->run();
        }
    }
}
