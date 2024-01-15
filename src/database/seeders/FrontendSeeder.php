<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Admin\Frontend;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
class FrontendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        


        $frontendsKeys = Frontend::distinct()->pluck('key')->toArray();

        $sections =  [


            "contact_us" => [

                "content"  => [
                    "banner_title" => "Get In Touch With us",
                    "banner_description" => "Our 24/7 support experts are here to assist you through tough times, so you get back to building exciting projects",
                    "support_title" => "Are you an existing customer?",
                    "support_description" => "If so, please click the button on the right to open a support ticket.",
                    "button_name" => "Open Support Ticket",
                    "button_url" => "####",
                    "section_title" => "Contact us",
                    "section_heading" => "We'd love hear from you",
                    "section_description" => "We welcome all the questions & remarks. Growth is the only constant in our",
                ],

                

            ],

            "feedback" => [

                "content"  => [
                    "banner_title" => "Get In Touch With us",
                    "banner_description" => "Our 24/7 support experts are here to assist you through tough times, so you get back to building exciting projects",
                    "heading" => "We'd love hear from you",
                    "description" => "We welcome all the questions & remarks. Growth is the only constant in our",
                ],

                

            ],

            "cta" => [

                "content"  => [
                    "title" => "Ready to get those mind-blowing ideas?",
                    "description" => "Track the engagement rate, comments, likes, shares, and impressions for each post, so you know whats working best for your audience. Once youve identified your high-performing posts, you can share them again."
                ],

                "element" => [
                    [
                        "button_name" => "Get Started",
                        "url" =>  "@@",
                    ],
                    [
                        "button_name" => "Contact Us",
                        "url" =>  "@@",
                    ]
                ]

            ],

            "cookie" => [

                "content"  => [
                    "description" => "We use cookies to enhance your browsing experience. By clicking 'Accept all, you agree to the use of cookies."
                ],

            ],

            "banner" => [

                "content"  => [

                    "title"             => "A powerful solution for social media",
                    "motion_text"       => "Explore more - Explore more",
                    "motion_button_url" => "@@",
                    "description"       => "Our all-in-one social media management platform unlocks the full potential of social to transform not just your marketing strategy—but every area of your organization.",
                    "button_left_name"  =>  "Get started for free",
                    "button_left_url"   =>  "@@",
                    "button_right_name" =>  "Book a demo",
                    "button_right_url"  =>  "@@"
                ]

            ],

            "about" => [

                "content" => [
                    "title"        => "Propelling your brand to new heights in the digital realm",
                    "sub_title"    => "Learn About Us",
                    "button_name"  => "Learn More",
                    "button_url"   => "@@",
                    "description"  => "Our vision is to be the driving force behind businesses, success in the digital age, where social media is not just a platform but a powerful tool for growth and engagement.",
                ],

                "element" => [

                    [
                        "icon"  => "bi bi-graph-up-arrow",
                        "name"  => "Amplify your Profile",
                    ],
                    [
                        "icon"  => "bi bi-cast",
                        "name"  => "Amplify your brand",
                    ],
                    [
                        "icon"  => "bi bi-circle-square",
                        "name"  => "Engage your audience",
                    ],
                    [
                        "icon"  => "bi bi-graph-up-arrow",
                        "name"  => "Drive tangible results",
                    ]

                ]
                
            ],

            "platform"  => [

                "content" => [
                    "title"        => "Propelling your brand to new heights",
                    "sub_title"    => "Platform",
                    "description"  => "Our vision is to be the driving force behind businesses’ success in the digital age, where social media is not just a platform but a powerful tool for growth and engagement.",
                ],

                "element" => [

                    [
                        "icon"        =>  "bi bi-pencil-square",
                        "title"       =>  "Create Caption",
                        "sub_title"   =>  "Make posts with our Canva integration or AI Assistant",
                        "description" =>  "<h5>Manage All Your Social Media Channels with SocialBee</h5>
                                            <p>
                                                Create, schedule, and post content across several
                                                social media accounts from one place.
                                            </p>
                                            <ul>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                            </ul>",
                    ],
                    [
                        "icon"        =>  "bi bi-person-gear",
                        "title"       =>  "Manage Profile",
                        "sub_title"   =>  "Manage your social media profiles from SocialBee.",
                        "description" =>  "<h5>Manage All Your Social Media Channels with SocialBee</h5>
                                            <p>
                                                Create, schedule, and post content across several
                                                social media accounts from one place.
                                            </p>
                                            <ul>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                            </ul>",
                    ],

                    [
                        "icon"        =>  "bi bi-hourglass-split",
                        "title"       =>  "Schedule Post",
                        "sub_title"   =>  "Schedule posts ahead of time in a calendar",
                        "description" =>  "<h5>Manage All Your Social Media Channels with SocialBee</h5>
                                            <p>
                                                Create, schedule, and post content across several
                                                social media accounts from one place.
                                            </p>
                                            <ul>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                            </ul>",
                    ],

                    [
                        "icon"        =>  "bi bi-inboxes",
                        "title"       =>  "Engagement",
                        "sub_title"   =>  "Schedule posts ahead of time in a calendar",
                        "description" =>  "<h5>Manage All Your Social Media Channels with SocialBee</h5>
                                            <p>
                                                Create, schedule, and post content across several
                                                social media accounts from one place.
                                            </p>
                                            <ul>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                                <li>
                                                <span><i class=\"bi bi-activity\"></i></span>
                                                <p>Multiple Profile</p>
                                                </li>
                                            </ul>",
                    ],
                   

                ]

            ],

            "integration" => [

                "content"  => [

                    "title" =>  "Connect information and data from
                    your most trusted social.",
                    "sub_title" =>  "Our Integrations",
                    "description" =>  "No more jumping between platforms. Access all the content and data your org needs to best serve your audience in one place and share that information across teams with efficiency.",
                ]

            ],

            "feature" => [

                "content"  => [

                    "title" =>  "Connect information and data from
                    your most trusted social.",
                    "sub_title" =>  "Key Features",
                    "description" =>  "No more jumping between platforms. Access all the content and data your org needs to best serve your audience in one place and share that information across teams with efficiency.",
                ],

                "element" => [

                    [
                        "icon"        =>  "bi bi-calendar2-range",
                        "title"       =>  "Social Media Calendar",
                        "sub_title"   =>  "Access a complete view of planned content",

                        "description" =>  "<div class=\"feature-content\">
                                            <h5>
                                                    Connect information and data from your most trusted
                                                    social networks.
                                            </h5>
                                            <p>
                                                No more jumping between platforms. Access all the
                                                content and data your org needs to best.
                                            </p>

                                                <ul>
                                                    <li>
                                                        <span>1</span>
                                                        <h6>
                                                        Bulk Schedule and Pause Content Categories
                                                        </h6>
                                                    </li>

                                                    <li>
                                                        <span>2</span>
                                                        <h6>Create Evergreen</h6>
                                                    </li>
                                                    <li>
                                                        <span>3</span>
                                                        <h6>Posting Sequences</h6>
                                                    </li>
                                                    <li>
                                                        <span>4</span>
                                                        <h6>Create Evergreen</h6>
                                                    </li>
                                                    <li>
                                                        <span>5</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>
                                                    <li>
                                                        <span>6</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>

                                                    <li>
                                                        <span>7</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>
                                                </ul>
                                            </div>",
                       
                    ],
                    [
                        "icon"        =>  "bi bi-stack",
                        "title"       =>  "Bulk Scheduling",
                        "sub_title"   =>  "Schedule posts ahead of time in a calendar.",
                        "description" =>  "<div class=\"feature-content\">
                                            <h5>
                                                    Connect information and data from your most trusted
                                                    social networks.
                                            </h5>
                                            <p>
                                                No more jumping between platforms. Access all the
                                                content and data your org needs to best.
                                            </p>

                                                <ul>
                                                    <li>
                                                        <span>1</span>
                                                        <h6>
                                                        Bulk Schedule and Pause Content Categories
                                                        </h6>
                                                    </li>

                                                    <li>
                                                        <span>2</span>
                                                        <h6>Create Evergreen</h6>
                                                    </li>
                                                    <li>
                                                        <span>3</span>
                                                        <h6>Posting Sequences</h6>
                                                    </li>
                                                    <li>
                                                        <span>4</span>
                                                        <h6>Create Evergreen</h6>
                                                    </li>
                                                    <li>
                                                        <span>5</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>
                                                    <li>
                                                        <span>6</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>

                                                    <li>
                                                        <span>7</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>
                                                </ul>
                                            </div>",
                    ],

                    [
                        "icon"        =>  "bi bi-magic",
                        "title"       =>  "AI Assistant",
                        "sub_title"   =>  "Create Content Faster with AI.",
                        "description" =>  "<div class=\"feature-content\">
                                            <h5>
                                                    Connect information and data from your most trusted
                                                    social networks.
                                            </h5>
                                            <p>
                                                No more jumping between platforms. Access all the
                                                content and data your org needs to best.
                                            </p>

                                                <ul>
                                                    <li>
                                                        <span>1</span>
                                                        <h6>
                                                        Bulk Schedule and Pause Content Categories
                                                        </h6>
                                                    </li>

                                                    <li>
                                                        <span>2</span>
                                                        <h6>Create Evergreen</h6>
                                                    </li>
                                                    <li>
                                                        <span>3</span>
                                                        <h6>Posting Sequences</h6>
                                                    </li>
                                                    <li>
                                                        <span>4</span>
                                                        <h6>Create Evergreen</h6>
                                                    </li>
                                                    <li>
                                                        <span>5</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>
                                                    <li>
                                                        <span>6</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>

                                                    <li>
                                                        <span>7</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>
                                                </ul>
                                            </div>",
                    ],

                    [
                        "icon"        =>  "bi bi-inboxes",
                        "title"       =>  "Engagement",
                        "sub_title"   =>  "Schedule posts ahead of time in a calendar",
                        "description" =>  "<div class=\"feature-content\">
                                                <h5>
                                                        Connect information and data from your most trusted
                                                        social networks.
                                                </h5>
                                                <p>
                                                    No more jumping between platforms. Access all the
                                                    content and data your org needs to best.
                                                </p>

                                                    <ul>
                                                    <li>
                                                        <span>1</span>
                                                        <h6>
                                                        Bulk Schedule and Pause Content Categories
                                                        </h6>
                                                    </li>

                                                    <li>
                                                        <span>2</span>
                                                        <h6>Create Evergreen</h6>
                                                    </li>
                                                    <li>
                                                        <span>3</span>
                                                        <h6>Posting Sequences</h6>
                                                    </li>
                                                    <li>
                                                        <span>4</span>
                                                        <h6>Create Evergreen</h6>
                                                    </li>
                                                    <li>
                                                        <span>5</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>
                                                    <li>
                                                        <span>6</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>

                                                    <li>
                                                        <span>7</span>
                                                        <h6>Create Evergreen Posting Sequences</h6>
                                                    </li>
                                                    </ul>
                                           </div>",
                    ],
                   

                ]


            ],

            "content" => [

                "content"  => [

                    "title" => "Work smarter, faster using AI and automation",
                    "sub_title" => "AI CONTENT CREATION",
                    "description" => "Discover a wealth of post ideas and captions with the AI Assistant on Feedswiz. Say goodbye to creative blocks as the AI generates an abundance of unique and engaging ideas, ensuring your social media calendar never falls short of inspiration."
                ]

            ],

            "template" => [

                "content"  => [

                    "title" => "Pre-build Templates for all social",
                    "sub_title" => "Templates",
                    "description" => "Discover a wealth of post ideas and captions with the AI Assistant on Feedswiz. Say goodbye to creative blocks as the AI generates an abundance of unique and engaging ideas, ensuring your social media calendar never falls short of inspiration."
                ]

            ],

            "analytics" => [

                "content"  => [

                    "title" => "Watch Your Accounts Grow",
                    "sub_title" => "Analytics & Reports",
                    "button_name"=> "View More",
                    "button_url"=> "##",
                    "description" => "Track the engagement rate, comments, likes, shares, and impressions for each post, so you know what’s working best for your audience. Once you’ve identified your high-performing posts, you can share them again."
                ]

            ],

            "why_us" => [

                "content"  => [

                    "title" => "Watch Your Accounts Grow",
                    "sub_title" => "Why Feedswiz",
                    "button_name"=> "View More",
                    "button_url"=> "##",
                    "description" => "Track the engagement rate, comments, likes, shares, and impressions for each post, so you know what’s working best for your audience. Once you’ve identified your high-performing posts, you can share them again."
                ],
                "element"  =>  [
                    [
                        "icon" => "bi bi-magic",
                        "title" => "AI Content Generation",
                        "description"=>"Generate captions and images based on prompts, summarize complex content, and turn your product descriptions into highly converting posts.",
                    ],
                    [
                        "icon" => "bi bi-magic",
                        "title" => "AI Content Generation",
                        "description"=>"Generate captions and images based on prompts, summarize complex content, and turn your product descriptions into highly converting posts.",
                    ],
                    [
                        "icon" => "bi bi-magic",
                        "title" => "AI Content Generation",
                        "description"=>"Generate captions and images based on prompts, summarize complex content, and turn your product descriptions into highly converting posts.",
                    ],
                    [
                        "icon" => "bi bi-magic",
                        "title" => "AI Content Generation",
                        "description"=>"Generate captions and images based on prompts, summarize complex content, and turn your product descriptions into highly converting posts.",
                    ],
                    [
                        "icon" => "bi bi-magic",
                        "title" => "AI Content Generation",
                        "description"=>"Generate captions and images based on prompts, summarize complex content, and turn your product descriptions into highly converting posts.",
                    ],
                    [
                        "icon" => "bi bi-magic",
                        "title" => "AI Content Generation",
                        "description"=>"Generate captions and images based on prompts, summarize complex content, and turn your product descriptions into highly converting posts.",
                    ]
                ]

            ],

            "faq" => [

                "content"  => [

                    "title" => "Frequently Asked Questions",
                    "sub_title" => "FAQS",
                    "description" => "We cant wait for you to explore all of our stories and create your own learning journeys. Before you do, here are the questions we get asked the most by our visitors."
                ],
                "element"  => [

                    [
                        "icon" => "bi bi-vector-pen",
                        "question" => "Whats it like your job, grab a backpack, and travel the
                        world?",
                        "answer" => "Some of the strangest places on earth are also the most
                        sublime: from the UFO-like dragon's blood trees in Yemen
                        to a rainbow-colored hot spring in Yellowstone to a bridge
                        in Germany that looks like a leftover prop from Lord of
                        the Rings."
                    ],
                    [
                        "icon" => "bi bi-globe",
                        "question" => "If I visit your country, whats
                        the one meal I shouldnt miss?",
                        "answer" => "Morbi aliquam quis quam in luctus. Nullam tincidunt
                        pulvinar imperdiet. Sed varius, diam vitae posuere semper,
                        libero ex hendrerit nunc, ac sagittis eros metus ut diam.
                        Donec a nibh in libero maximus vehicula. Etiam sit amet
                        condimentum erat. Pellentesque ultrices sagittis turpis,
                        quis tempus ante viverra et.Morbi aliquam quis quam in
                        luctus. Nullam tincidunt pulvinar imperdiet. Sed varius,
                        diam vitae posuere semper, tincidunt pulvinar imperdiet.
                        Sed varius, diam vitae posuere semper."
                    ],
                    [
                        "icon" => "bi bi-people",
                        "question" => "What are the most beautiful beaches in the world?",
                        "answer" => "Morbi aliquam quis quam in luctus. Nullam tincidunt
                        pulvinar imperdiet. Sed varius, diam vitae posuere semper,
                        libero ex hendrerit nunc, ac sagittis eros metus ut diam.
                        Donec a nibh in libero maximus vehicula. Etiam sit amet
                        condimentum erat. Pellentesque ultrices sagittis turpis,
                        quis tempus ante viverra et.Morbi aliquam quis quam in
                        luctus. Nullam tincidunt pulvinar imperdiet. Sed varius,
                        diam vitae posuere semper, tincidunt pulvinar imperdiet.
                        Sed varius, diam vitae posuere semper."
                    ],

                    [
                        "icon" => "bi bi-briefcase",
                        "question" => "Who s the most interesting person you’ve ever met on a
                        plane",
                        "answer" => "Morbi aliquam quis quam in luctus. Nullam tincidunt
                        pulvinar imperdiet. Sed varius, diam vitae posuere semper,
                        libero ex hendrerit nunc, ac sagittis eros metus ut diam.
                        Donec a nibh in libero maximus vehicula. Etiam sit amet
                        condimentum erat. Pellentesque ultrices sagittis turpis,
                        quis tempus ante viverra et.Morbi aliquam quis quam in
                        luctus. Nullam tincidunt pulvinar imperdiet. Sed varius,
                        diam vitae posuere semper, tincidunt pulvinar imperdiet.
                        Sed varius, diam vitae posuere semper."
                    ],
                   
                ],

            ],
            "plan" => [

                "content"  => [

                    "title" => "Life Planning, Making Easy to Turn Dreams a Reality",
                    "sub_title" => "Pricing Plan",
                    "button_name"=> "Contact Us",
                    "button_url"=> "##",
                    "description" => "We offer flexible pricing plans to suit the diverse needs of our clients."
                ]

            ],

            "testimonial" => [

                "content"  => [

                    "title" => "What our client say.",
                    "sub_title" => "Reviews",
                    "description" => "Track the engagement rate, comments, likes, shares, and impressions for each post, so you know what’s working best for your audience"
                ] ,
                "element"  =>  [
                    [
                        "author" => "Sam Wister",
                        "designation" => "Social media manager",
                        "quote" => "I recently got the XYZ Pro, and it's been a game-changer. The performance is top-notch—apps run smoothly, and multitasking is a breeze. The sleek design is a head-turner, and the camera captures stunning shots, even in low light. The battery easily lasts a day, and fast charging is a great perk. My only minor gripe is the fingerprint sensor placement. Overall, a fantastic investment for tech enthusiasts!",
                        "rating" => 3,
           
                    ],
                  
                    [
                        "author" => "Sam Wister",
                        "designation" => "Social media manager",
                        "quote" => "I recently got the XYZ Pro, and it's been a game-changer. The performance is top-notch—apps run smoothly, and multitasking is a breeze. The sleek design is a head-turner, and the camera captures stunning shots, even in low light. The battery easily lasts a day, and fast charging is a great perk. My only minor gripe is the fingerprint sensor placement. Overall, a fantastic investment for tech enthusiasts!",
                        "rating" => 4,
           
                    ],
                  
                    [
                        "author" => "Sam Wister",
                        "designation" => "Social media manager",
                        "quote" => "I recently got the XYZ Pro, and it's been a game-changer. The performance is top-notch—apps run smoothly, and multitasking is a breeze. The sleek design is a head-turner, and the camera captures stunning shots, even in low light. The battery easily lasts a day, and fast charging is a great perk. My only minor gripe is the fingerprint sensor placement. Overall, a fantastic investment for tech enthusiasts!",
                        "rating" => 2,
           
                    ],
                  
                    [
                        "author" => "Sam Wister",
                        "designation" => "Social media manager",
                        "quote" => "I recently got the XYZ Pro, and it's been a game-changer. The performance is top-notch—apps run smoothly, and multitasking is a breeze. The sleek design is a head-turner, and the camera captures stunning shots, even in low light. The battery easily lasts a day, and fast charging is a great perk. My only minor gripe is the fingerprint sensor placement. Overall, a fantastic investment for tech enthusiasts!",
                        "rating" => 5,
           
                    ],
                  
                    [
                        "author" => "Sam Wister",
                        "designation" => "Social media manager",
                        "quote" => "I recently got the XYZ Pro, and it's been a game-changer. The performance is top-notch—apps run smoothly, and multitasking is a breeze. The sleek design is a head-turner, and the camera captures stunning shots, even in low light. The battery easily lasts a day, and fast charging is a great perk. My only minor gripe is the fingerprint sensor placement. Overall, a fantastic investment for tech enthusiasts!",
                        "rating" => 1,
           
                    ],
                  
                  
                   
                ]

            ],

            "blog" => [

                "content"  => [

                    "title" => "Latest News",
                    "sub_title" => "Blogs",
                    "banner_title" => "Feedswiz Blog",
                    "banner_description"=> "Master social media with the latest expert tips & trends: tailored for entrepreneurs, small businesses, and agencies.",
                    "button_name"=> "View More",
                    "button_url"=> "@@",
                    "description" => "Track the engagement rate, comments, likes, shares, and impressions for each post, so you know what’s working best for your audience. Once you’ve identified your high-performing posts, you can share them again."
                ]

            ],

            "newsletter" => [

                "content"  => [
                    "title" => "Subscribe",
                    "description" => "Enter your email to recive relevent messaging tips and offers."
                ],
                
            ],

            
            "social_icon" => [

                "element"  => [
                   
                    [
                        "social_icon" =>  "bi bi-facebook",
                        "title"=> "facebook",
                        "url"=> "@@",
                    ],
                    [
                        "social_icon" =>  "bi bi-linkedin",
                        "title"=> "linkedin",
                        "url"=> "@@",
                    ],
                    [
                        "social_icon" =>  "bi bi-instagram",
                        "title"=> "instagram",
                        "url"=> "@@",
                    ],
                    [
                        "social_icon" =>  "bi bi-twitter",
                        "title"=> "twitter",
                        "url"=> "@@",
                    ],
                    [
                        "social_icon" =>  "bi bi-youtube",
                        "title"=> "youtube",
                        "url"=> "@@",
                    ],
                    [
                        "social_icon" =>  "bi bi-tiktok",
                        "title"=> "tiktok",
                        "url"=> "@@",
                    ],
                ],
                
            ],

            "footer" => [

                "content"  => [
                   
                ],
                
            ],

            
            "mega_menu" => [

                "content"  => [
                   "select_input" => [
                     "status" => StatusEnum::true->status()
                   ],
                   "title" => "Platform",
                ],
                
            ],

            "authentication_section" => [

                "content"  => [
                    "description" => "Uncover the untapped potential of your growth to connect with clients."
                ],

                "element" => [

                    [
                        "title"       => "Easy to use dashboard",
                        "description" => "Choose the best of product/service and get a
                        bare metal server at the lowest prices."
                    ],
                    [
                        "title"       => "Easy to use dashboard",
                        "description" => "Choose the best of product/service and get a
                        bare metal server at the lowest prices."
                    ],
                    [
                        "title"       => "Easy to use dashboard",
                        "description" => "Choose the best of product/service and get a
                        bare metal server at the lowest prices."
                    ],
                    [
                        "title"       => "Easy to use dashboard",
                        "description" => "Choose the best of product/service and get a
                        bare metal server at the lowest prices."
                    ],
                ]
                
            ],

        ];

        foreach($sections as $key => $sectionValues){

            if(isset($sectionValues['content'])){
                $insertionKey =  "content_".$key ;
                if(!in_array($insertionKey,$frontendsKeys)){
                    Frontend::create(
                        [
                            'key'   => $insertionKey ,
                            'value' => $sectionValues['content']
                        ]
                   
                    );
                }
            }

            if(isset($sectionValues['element'])){
                $insertionKey =  "element_".$key ;
                if(!in_array($insertionKey,$frontendsKeys)){
                    foreach($sectionValues['element'] as $element){
                        Frontend::create(
                            [
                                'key'   => $insertionKey ,
                                'value' => $element
                            ]
                        );
                    }
                }

            }


        }


        Cache::forget('frontend_content');




    }
}
