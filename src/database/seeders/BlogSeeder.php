<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            "we-launch-pulsar-template-this-week",
            "template-this-week",
            "AI-content",
            "social-posting",
            "post-management",
       ])->except(Blog::pluck('slug')->toArray())
        ->each(fn(string $title ,int $index): Blog=>
                Blog::create([
                                'title'       => k2t($title),
                                    'description' => '<p class="mb-30" style="color: rgb(84, 84, 84); font-size: 16px; font-family: Jost, sans-serif;">Vestibulum egestas amet, morbi facilisis semper mi placerat ac. Et tristique mus vel eu libero, lacus sit consectetur. Tristique dapibus fringilla in lectus ullamcorper tristique risus id nunc. Enim mi a, sapien velit dolor sagittis. Erat posuere aliquam, sit maecenas a neque lectus commodo scelerisque. Volutpat purus facilisis egestas risus convallis libero morbi est orci. Senectus a senectus cursus consectetur egestas eu fringilla eu phasellus. Tristique mollis velit.</p><h4 class="sub-title mb-3" style="line-height: 1.3; font-size: 24px; font-family: Jost, sans-serif;">Adipiscing lacus dui rutrum quam. In morbi facilisis elit.</h4><p class="mb-3" style="color: rgb(84, 84, 84); font-size: 16px; font-family: Jost, sans-serif;">Tincidunt et amet suspendisse venenatis neque ultricies eget. Aliquam duis amet amet lobortis. Elit risus ultrices gravida fringilla id odio tortor, vitae. In pretium purus ac potenti pretium ultrices. Aliquam velit scelerisque auctor in libero amet. Commodo faucibus consequat, dolor fringilla volutpat sed nibh. Amet, sit ut id eget. Egestas hendrerit.</p>',
                                'is_feature' => StatusEnum::true->status(),
                                'slug'        => $title])
                );
    }
}
