<?php


class ExamplePredefinedMessages extends \App\Services\TenantSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $predefinedMessagesSeeder = new PredefinedMessagesSeeder();
        $recruitments = \App\Models\Recruitment::get();

        foreach ($recruitments as $recruitment) {
            $predefinedMessagesSeeder->run($recruitment);
        }
    }
}
