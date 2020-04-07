<?php


class ExampleStages extends \App\Services\TenantSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stagesSeeder = new StagesSeeder();
        $recruitments = \App\Models\Recruitment::get();

        foreach ($recruitments as $recruitment) {
            $stagesSeeder->run($recruitment);
            break; //TODO na razie nie obsługujemy osobnych konfiguracji etapów per rekrutacja
        }
    }
}
