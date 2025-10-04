<?php

namespace Tests\Feature\Workspace;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admin\GrupoEmpresarial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

class WorkspaceArchitectureTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $grupoEmpresarial;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear un usuario de prueba
        $this->user = User::factory()->create([
            'name' => 'Usuario Test',
            'email' => 'test@example.com',
            'is_super_admin' => false,
        ]);

        // Crear un grupo empresarial de prueba
        $this->grupoEmpresarial = GrupoEmpresarial::create([
            'user_uuid' => $this->user->id,
            'nombre' => 'Grupo Test',
            'codigo' => 'TEST001',
            'slug' => 'grupo-test',
            'estado' => true,
        ]);
    }

    /** @test */
    public function workspace_routes_are_registered_correctly()
    {
        $expectedRoutes = [
            'workspace.dashboard',
            'workspace.apps',
            'workspace.config.index',
            'workspace.config.empresas',
            'workspace.config.usuarios',
            'workspace.reportes.index',
            'workspace.reportes.general',
            'workspace.customization.index',
            'workspace.customization.update',
            'workspace.customization.reset',
            'workspace.customization.settings',
        ];

        foreach ($expectedRoutes as $routeName) {
            $this->assertTrue(
                Route::has($routeName),
                "La ruta '{$routeName}' no está registrada"
            );
        }
    }

    /** @test */
    public function workspace_dashboard_requires_authentication()
    {
        $response = $this->get("/grupo-test/");
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function workspace_dashboard_requires_valid_grupo()
    {
        $this->actingAs($this->user);
        
        $response = $this->get("/grupo-inexistente/");
        $response->assertStatus(404);
    }

    /** @test */
    public function workspace_dashboard_works_with_valid_grupo()
    {
        $this->actingAs($this->user);
        
        $response = $this->get("/grupo-test/");
        $response->assertStatus(200);
    }

    /** @test */
    public function workspace_customization_route_works()
    {
        $this->actingAs($this->user);
        
        $response = $this->get("/grupo-test/customization");
        $response->assertStatus(200);
    }

    /** @test */
    public function workspace_config_routes_work()
    {
        $this->actingAs($this->user);
        
        $configRoutes = [
            '/configuracion',
            '/configuracion/empresas',
            '/configuracion/usuarios',
        ];

        foreach ($configRoutes as $route) {
            $response = $this->get("/grupo-test{$route}");
            $response->assertStatus(200);
        }
    }

    /** @test */
    public function workspace_reportes_routes_work()
    {
        $this->actingAs($this->user);
        
        $reporteRoutes = [
            '/reportes',
            '/reportes/general',
        ];

        foreach ($reporteRoutes as $route) {
            $response = $this->get("/grupo-test{$route}");
            $response->assertStatus(200);
        }
    }

    /** @test */
    public function user_can_only_access_their_own_grupos()
    {
        // Crear otro usuario y grupo
        $otherUser = User::factory()->create();
        $otherGrupo = GrupoEmpresarial::create([
            'user_uuid' => $otherUser->id,
            'nombre' => 'Otro Grupo',
            'codigo' => 'OTHER001',
            'slug' => 'otro-grupo',
            'estado' => true,
        ]);

        $this->actingAs($this->user);
        
        // Intentar acceder al grupo de otro usuario
        $response = $this->get("/otro-grupo/");
        $response->assertStatus(403);
    }

    /** @test */
    public function super_admin_can_access_any_grupo()
    {
        // Hacer al usuario super admin
        $this->user->update(['is_super_admin' => true]);
        
        // Crear otro grupo de otro usuario
        $otherUser = User::factory()->create();
        $otherGrupo = GrupoEmpresarial::create([
            'user_uuid' => $otherUser->id,
            'nombre' => 'Otro Grupo',
            'codigo' => 'OTHER001',
            'slug' => 'otro-grupo',
            'estado' => true,
        ]);

        $this->actingAs($this->user);
        
        // Super admin debe poder acceder
        $response = $this->get("/otro-grupo/");
        $response->assertStatus(200);
    }

    /** @test */
    public function debug_route_returns_correct_information()
    {
        $this->actingAs($this->user);
        
        $response = $this->get('/debug-grupos');
        $response->assertStatus(200);
        
        $data = $response->json();
        
        $this->assertEquals($this->user->id, $data['user_id']);
        $this->assertEquals($this->user->name, $data['user_name']);
        $this->assertIsArray($data['todos_los_grupos']);
        $this->assertIsArray($data['grupos_del_usuario']);
    }

    /** @test */
    public function route_parameters_validation_works()
    {
        $this->actingAs($this->user);
        
        // Test con caracteres no permitidos
        $invalidSlugs = [
            'grupo@test',
            'grupo test',
            'grupo#test',
            'grupo.test',
        ];

        foreach ($invalidSlugs as $slug) {
            $response = $this->get("/{$slug}/");
            $response->assertStatus(404);
        }
    }

    /** @test */
    public function fallback_route_redirects_correctly()
    {
        // Sin autenticación
        $response = $this->get('/ruta-inexistente');
        $response->assertRedirect(route('login'));

        // Con autenticación
        $this->actingAs($this->user);
        $response = $this->get('/ruta-inexistente');
        $response->assertRedirect('/apps');
    }
}