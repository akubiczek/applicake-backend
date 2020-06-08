<?php

/**
 * This seeder is used in production code to seeds form fields for new recruitments. Be careful!
 */
class FormFieldsSeeder extends \App\Services\TenantSeeder
{
    use \App\Services\WithRecruitment;

    const JSON_PATH = '/database/seeds/form_fields.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fields = json_decode(file_get_contents(base_path() . self::JSON_PATH), true);
        $now = \Carbon\Carbon::now()->toDateTimeString();

        foreach ($fields as $field) {
            DB::connection($this->connection)->table('form_fields')->insert([
                'name' => $field['name'],
                'label' => $field['label'],
                'system' => $field['system'],
                'type' => $field['type'],
                'required' => $field['required'],
                'order' => $field['order'],
                'recruitment_id' => $this->recruitment->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
