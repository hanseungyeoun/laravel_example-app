<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 글쓰기_화면을_볼_수있다(): void
    {
        $this->get(route("articles.create"))
            ->assertStatus(200)
            ->assertSee('글쓰기');
    }

    /**
     * @test
     */
    public function 글을_작성할_수_있다(): void
    {
        $user = User::factory()->create();
        $testData =  [
            'body' => 'test article'
        ];

        $this->actingAs($user)
            ->post(route("articles.store"), $testData)
            ->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', $testData);
    }

    /**
     * @test
     */
    public function 글을_목록을_확인_할_수_있다()
    {
        $now = Carbon::now();
        $affertOneSecond = (clone $now)->addSecond(10);
        $acticle1 = Article::factory()->create(
            ['created_at' => $now]
        );
        $acticle2 = Article::factory()->create(
            ['created_at' => $affertOneSecond]
        );

        $res = $this->get(route('articles.index'))
            ->assertSee($acticle1->body)
            ->assertSee($acticle2->body);
        // ->assertSeeInOrder(
        //     $acticle2->body,
        //     $acticle1->body
        // );
    }

    /**
     * @test
     */
    public function 개별글을_조회할_수_있다()
    {
        $acticle = Article::factory()->create();
        $res = $this->get(route('articles.show', ['article' => $acticle->id]))
            ->assertSee($acticle->body)
            ->assertSuccessful();
    }


    /**
     * @test
     */
    public function 글_수정_화면을_볼_수_있다()
    {
        $acticle = Article::factory()->create();
        $res = $this->get(route('articles.edit', ['article' => $acticle]))
            ->assertSee($acticle->body)
            ->assertSuccessful();
    }

    /**
     * @test
     */
    public function 글을_수정_할_수_있다()
    {
        $payload = ['body' => '수정된 글'];
        $acticle = Article::factory()->create();
        $this->patch(
            route('articles.update', ['article' => $acticle->id]),
            $payload
        )->assertRedirect(route("articles.index"));

        $this->assertDatabaseHas('articles', $payload);
        $this->assertEquals($payload['body'], $acticle->refresh()->body);
    }

    /**
     * @test
     */
    public function 글을_삭제_할_수_있다()
    {
        $acticle = Article::factory()->create();
        $this->delete(
            route('articles.delete', ['article' => $acticle->id]),
        )->assertRedirect(route("articles.index"));

        $this->assertDatabaseMissing('articles', ['id' => $acticle->id]);
    }
}
