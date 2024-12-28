<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Company;
use App\User;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCompanyCanBeCreated()
    {
        // $user = factory(User::class)->create();
        // $this->actingAs($user);

        $response = $this->post('/companies', [
            'name' => 'Empresa de Prueba',
            'country' => 'Venezuela',
            'type' => 'Tech',
            'importance' => 5,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/companies');
        $this->assertDatabaseHas('companies', [
            'name' => 'Empresa de Prueba',
            'country' => 'Venezuela',
            'type' => 'Tech',
            'importance' => 5,
        ]);
    }

    public function testCompaniesCanBeListed()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        factory(Company::class, 5)->create();

        $response = $this->get('/companies');

        $response->assertStatus(200);
        $response->assertSee(Company::first()->name);
    }

    /** @test */
    public function name_is_required()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $response = $this->post('/companies', [
            'name' => '',
            'country' => 'Venezuela',
            'type' => 'Tech',
            'importance' => 5,
        ]);

        $response->assertSessionHasErrors('name');
    }
    
    /** @test */
    public function name_must_be_unique()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        // Crear una compañía para verificar la unicidad
        $this->post('/companies', [
            'name' => 'Empresa de Prueba',
            'country' => 'Venezuela',
            'type' => 'Tech',
            'importance' => 5,
        ]);

        // Intentar crear otra compañía con el mismo nombre
        $response = $this->post('/companies', [
            'name' => 'Empresa de Prueba',
            'country' => 'Colombia',
            'type' => 'Finance',
            'importance' => 3,
        ]);

        $response->assertSessionHasErrors('name');
    }
    
    /** @test */
    public function country_can_be_null()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $response = $this->post('/companies', [
            'name' => 'Empresa de Prueba',
            'country' => null,
            'type' => 'Tech',
            'importance' => 5,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('companies', [
            'name' => 'Empresa de Prueba',
            'country' => null,
        ]);
    }
    
    /** @test */
    public function importance_is_required()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $response = $this->post('/companies', [
            'name' => 'Empresa de Prueba',
            'country' => 'Venezuela',
            'type' => 'Tech',
            'importance' => null,
        ]);

        $response->assertSessionHasErrors('importance');
    }

    /** @test */
    public function importance_must_be_integer()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $response = $this->post('/companies', [
            'name' => 'Empresa de Prueba',
            'country' => 'Venezuela',
            'type' => 'Tech',
            'importance' => 'cinco',
        ]);

        $response->assertSessionHasErrors('importance');
    }

    /** @test */
    public function importance_must_be_between_1_and_10()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        // Valor menor que 1
        $response = $this->post('/companies', [
            'name' => 'Empresa de Prueba',
            'country' => 'Venezuela',
            'type' => 'Tech',
            'importance' => 0,
        ]);

        $response->assertSessionHasErrors('importance');

        // Valor mayor que 10
        $response = $this->post('/companies', [
            'name' => 'Empresa de Prueba',
            'country' => 'Venezuela',
            'type' => 'Tech',
            'importance' => 11,
        ]);

        $response->assertSessionHasErrors('importance');
    }

    public function edit_view_can_be_accessed()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $company = Company::factory()->create();

        $response = $this->get(route('companies.edit', $company));

        $response->assertStatus(200);
        $response->assertViewIs('companies.create'); // Verifica que se está usando la vista 'create'
        $response->assertViewHas('company', $company);
    }

    /** @test */
    public function company_can_be_updated()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $user = factory(User::class)->create();
        $this->actingAs($user);

        $company = factory(Company::class)->create([
            'name' => 'Original Name',
            'country' => 'Original Country',
            'type' => 'Original Type',
            'importance' => 5,
        ]);

        $response = $this->put("/companies/{$company->id}", [
            'name' => 'Updated Name',
            'country' => 'Updated Country',
            'type' => 'Updated Type',
            'importance' => 7,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/companies');
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'Updated Name',
            'country' => 'Updated Country',
            'type' => 'Updated Type',
            'importance' => 7,
        ]);
    }

    /** @test */
    public function company_can_be_activated()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $company = factory(Company::class)->create([
            'status' => 0, // Inicialmente desactivada
        ]);

        $response = $this->patch(route('companies.activate', $company));

        $response->assertStatus(302);
        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'status' => 1, // Verificamos que el status se actualizó a activo
        ]);
    }

    /** @test */
    public function company_can_be_desactivated()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $company = factory(Company::class)->create([
            'status' => 1, // Inicialmente activada
        ]);

        $response = $this->patch(route('companies.desactivate', $company));

        $response->assertStatus(302);
        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'status' => 0, // Verificamos que el status se actualizó a inactivo
        ]);
    }

    /** @test */
    public function company_can_be_deleted()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $company = factory(Company::class)->create([
            'status' => 1, // Inicialmente activada
        ]);

        $response = $this->delete(route('companies.destroy', $company));

        $response->assertStatus(302);
        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'status' => 2, // Verificamos que el status se actualizó a eliminado
        ]);
    }

}
