<?php

namespace Tests\Feature;

use App\Jobs\GenerateReport;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanCreateAReport()
    {
        Queue::fake();
        $user = factory(User::class)->create(['role_id' => 1]);

        $response = $this->actingAs($user)->get('/reports/create?report_type=1&datefilter=01%2F01%2F2020+-+04%2F01%2F2020');

        $response->assertRedirect('reports');
        $response->assertSessionHasNoErrors();
        Queue::assertPushed(GenerateReport::class, 1);
        Queue::assertPushed(GenerateReport::class, function ($job) {
            $job->handle();
            return $job->request === [
                    "report_type" => "1",
                    "datefilter" => "01/01/2020 - 04/01/2020",
                    "start_date" => "01/01/2020",
                    "end_date" => "01/04/2020"
                ];
        });
        $this->assertDatabaseCount('reports', 1);
    }

    public function testEditorCanCreateAReport()
    {
        Queue::fake();
        $user = factory(User::class)->create(['role_id' => 2]);

        $response = $this->actingAs($user)->get('/reports/create?report_type=1&datefilter=01%2F01%2F2020+-+04%2F01%2F2020');

        $response->assertRedirect('reports');
        $response->assertSessionHasNoErrors();
        Queue::assertPushed(GenerateReport::class, 1);
        Queue::assertPushed(GenerateReport::class, function ($job) {
            $job->handle();
            return $job->request === [
                    "report_type" => "1",
                    "datefilter" => "01/01/2020 - 04/01/2020",
                    "start_date" => "01/01/2020",
                    "end_date" => "01/04/2020"
                ];
        });
        $this->assertDatabaseCount('reports', 1);
    }

    public function testBuyerCanNotCreateAReport()
    {
        Queue::fake();
        $user = factory(User::class)->create(['role_id' => 3]);

        $response = $this->actingAs($user)->get('/reports/create?report_type=1&datefilter=01%2F01%2F2020+-+04%2F01%2F2020');

        $response->assertForbidden();
        Queue::assertNothingPushed();
    }

    public function testNotAuthenticatedUserCanNotCreateAReport()
    {
        Queue::fake();

        $response = $this->get('/reports/create?report_type=1&datefilter=01%2F01%2F2020+-+04%2F01%2F2020');

        $response->assertRedirect(route('verification.notice'));
        Queue::assertNothingPushed();
    }
}
