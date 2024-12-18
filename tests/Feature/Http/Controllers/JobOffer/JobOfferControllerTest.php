<?php

namespace Tests\Feature\Http\Controllers\JobOffer;

use App\JobOffer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobOfferControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testViewCreate()
    {
        // Simula una solicitud GET a la ruta create
        $response = $this->get('JobOffers/create');

        // Verifica que el código de respuesta sea 200 (OK)
        $response->assertStatus(200);

        // Verifica que la vista devuelta sea la correcta 
        $response->assertViewIs('JobOffer.create');
    }

    public function testJobOfferCreate() {
        // Crear datos de prueba usando el factory
        $jobOfferData = factory(JobOffer::class)->make()->toArray();

        // Simula una solicitud POST a la ruta store
        $response = $this->post('JobOffers', $jobOfferData);

        // Verifica que el código de respuesta sea 302 (redirección)
        $response->assertStatus(302);

        // Verifica que el registro fue creado en la base de datos
        $this->assertDatabaseHas('job_offers', $jobOfferData);
    }

    public function testEditJobOfferView()
    {
        // Crear una oferta de trabajo para editar
        $jobOffer = factory(JobOffer::class)->create();

        // Simula una solicitud GET a la ruta de edición
        $response = $this->get(route('JobOffers.edit', $jobOffer->id));

        // Verifica que el código de respuesta sea 200 (OK)
        $response->assertStatus(200);

        // Verifica que la vista contenga los datos de la oferta de trabajo
        $response->assertViewIs('JobOffer.create');

        $response->assertViewHas('JobOffer', $jobOffer);

        // Asegurarse de que la respuesta contiene el valor del título en el input 
        $response->assertSee('value="' . $jobOffer->title . '"', false); 
        $response->assertSee('value="' . $jobOffer->description . '"', false);
    }

    public function testJobOfferUpdate()
    {
        // Crear una oferta de trabajo ficticia en la base de datos
        $jobOffer = factory(JobOffer::class)->create([
            'title' => 'Desarrollador Backend',
            'description' => 'Trabajo en el desarrollo de aplicaciones backend',
            'Company' => 'Tech Corp',
            'idApplyStatus' => 1,
            'idPriority' => 2
        ]);
    
        // Nuevos datos para actualizar
        $updatedData = [
            'title' => 'Desarrollador Frontend',
            'description' => 'Trabajo en el desarrollo de interfaces frontend',
            'Company' => 'Innovatech',
            'idApplyStatus' => 2,
            'idPriority' => 1
        ];
    
        // Realizar una solicitud PUT a la página de actualización de la oferta de trabajo
        $response = $this->put(route('JobOffers.update', $jobOffer->id), $updatedData);
    
        // Verificar que la respuesta redirige correctamente
        $response->assertRedirect(route('JobOffers.index'));
    
        // Verificar que los datos se hayan actualizado en la base de datos
        $this->assertDatabaseHas('job_offers', [
            'id' => $jobOffer->id,
            'title' => 'Desarrollador Frontend',
            'description' => 'Trabajo en el desarrollo de interfaces frontend',
            'Company' => 'Innovatech',
            'idApplyStatus' => 2,
            'idPriority' => 1
        ]);
    
        // Verificar que no existen los antiguos datos en la base de datos
        $this->assertDatabaseMissing('job_offers', [
            'id' => $jobOffer->id,
            'title' => 'Desarrollador Backend',
            'description' => 'Trabajo en el desarrollo de aplicaciones backend',
            'Company' => 'Tech Corp',
            'idApplyStatus' => 1,
            'idPriority' => 2
        ]);
    }    

}
