<?php

namespace App\Controllers;

class StaffController
{
    public function __construct() {}

    public function dashboard()
    {
        return [
            'title' => 'Dashboard',
            'template' => 'staff-dashboard.html.php',
            'vars' => [
                'tempJobs' => [
                    [
                        "title" => "Job Title 1",
                        "role" => "Job One",
                        "location" => "Northampton",
                        "skills" => [
                            "Skill 1",
                            "Skill 2",
                            "Skill 3",
                            "Skill 4"
                        ],
                        "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ],
                    [
                        "title" => "Job Title 2",
                        "role" => "Job Two",
                        "location" => "Northampton",
                        "skills" => [
                            "Skill 1",
                            "Skill 2",
                            "Skill 3",
                            "Skill 4"
                        ],
                        "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ],
                    [
                        "title" => "Job Title 3",
                        "role" => "Job Three",
                        "location" => "Northampton",
                        "skills" => [
                            "Skill 1",
                            "Skill 2",
                            "Skill 3",
                            "Skill 4"
                        ],
                        "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ],
                    [
                        "title" => "Job Title 3",
                        "role" => "Job Four",
                        "location" => "Northampton",
                        "skills" => [
                            "Skill 1",
                            "Skill 2",
                            "Skill 3",
                            "Skill 4"
                        ],
                        "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    ]
                ]
            ]
        ];
    }
}