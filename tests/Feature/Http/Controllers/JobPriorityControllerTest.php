<?php

namespace Tests\Feature\Http\Controllers;

use App\JobPriority;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobPriorityControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_priority_index()
    {
        $response = $this->get('/jobPriorities');
        $response->assertStatus(200);
    }

    public function test_job_priority_create()
    {
        $response = $this->get('/jobPriorities/create');
        $response->assertStatus(200);
    }

    public function test_job_priority_store()
    {
        $data = [
            'name' => 'Alta',
            'description' => 'Prioridad Alta',
            'value' => 300
        ];

        $response = $this->post('/jobPriorities', $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('job_priorities', $data);
    }

    public function test_job_priority_update()
    {
        $jobPriority = factory(JobPriority::class)->create();


        $data = [
            'name' => 'Media',
            'description' => 'Prioridad Media',
            'value' => 200
        ];

        $response = $this->put("/jobPriorities/{$jobPriority->id}", $data);

        // $response = $this->put('/jobPriorities' . $jobPriority->id, $data);
        // dd($response);
        $response->assertStatus(302);

        $this->assertDatabaseHas('job_priorities', $data);
    }

    public function test_job_priority_delete()
    {
        $jobPriority = factory(JobPriority::class)->create();

        $response = $this->delete("/jobPriorities/{$jobPriority->id}");
        $response->assertStatus(302);
        $this->assertDatabaseHas('job_priorities', [
            'id' => $jobPriority->id,
            'status' => 2 // Verifica que el estado se haya cambiado a 2
        ]);
    }

    public function test_job_priority_activate()
    {
        $jobPriority = factory(JobPriority::class)->create(['status' => 0]);

        $response = $this->patch("/jobPriorities/{$jobPriority->id}/activate");
        $response->assertStatus(302);
        
        $this->assertDatabaseHas('job_priorities', [
            'id' => $jobPriority->id,
            'status' => 1 // Verifica que el estado se haya cambiado a 1
        ]);
    }

    public function test_job_priority_desactivate()
    {
        $jobPriority = factory(JobPriority::class)->create(['status' => 1]);

        $response = $this->patch("/jobPriorities/{$jobPriority->id}/desactivate");
        $response->assertStatus(302);
        $this->assertDatabaseHas('job_priorities', [
            'id' => $jobPriority->id,
            'status' => 0, // Verifica que el estado se haya cambiado a 0
        ]);
    }
}
