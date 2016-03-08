<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 23.02.16
 * Time: 15:43
 */

namespace app\callcenter\models;

use core\Models;

class Company extends Models
{
    public function getRawCompany($page=0)
    {
        $limit = PAGE_SIZE;
        $countData = $this->db->count('company', [
            'AND' => [
                'status_company' => 0,
                'operator' => 0
            ]
        ]);
        $countPage = ceil($countData / $limit);
        $offset = (int)$page * $limit;
        $companyData = $this->db->select("company", [
            "[>]status_type" => ["status_company" => "id"]
        ],
            [
                'company.id',
                'company.name',
                'company.ph_address',
                'company.date_create',
                'company.status_company',
                'status_type.name(status_name)',
                'company.location',
                'company.sale',
                'company.locked'],
            [
                'AND' => [
                    'status_company' => 0,
                    'operator' => 0
                ],
                'LIMIT' => [$offset, $limit],
                'ORDER' => ['id ASC']
            ]
        );

        return [
            'data' => $companyData,
            'count' => $countPage
        ];

    }

    public function getRejectCompany($user,$page=0)
    {
        $limit = PAGE_SIZE;
        $countData = $this->db->count('company', [
            'AND' => [
                'status_company' => 1,
                'operator' => $user
            ]
        ]);
        $countPage = ceil($countData / $limit);
        $offset = (int)$page * $limit;
        $companyData = $this->db->select("company", [
            "[>]status_type" => ["status_company" => "id"]
        ],
            [
                'company.id',
                'company.name',
                'company.ph_address',
                'company.date_create',
                'company.status_company',
                'status_type.name(status_name)',
                'company.location',
                'company.sale',
                'company.locked'],
            [
                'AND' => [
                    'status_company' => 1,
                    'operator' => $user
                ],
                'LIMIT' => [$offset, $limit],
                'ORDER' => ['id ASC']
            ]
        );

        return [
            'data' => $companyData,
            'count' => $countPage
        ];

    }

    public function getRecallCompany($user,$page=0)
    {
        $limit = PAGE_SIZE;
        $countData = $this->db->count('company', [
            'AND' => [
                'status_company' => 3,
                'operator' => $user
            ]
        ]);
        $countPage = ceil($countData / $limit);
        $offset = (int)$page * $limit;
        $companyData = $this->db->select("company", [
            "[>]status_type" => ["status_company" => "id"]
        ],
            [
                'company.id',
                'company.name',
                'company.ph_address',
                'company.date_create',
                'company.status_company',
                'status_type.name(status_name)',
                'company.location',
                'company.sale',
                'company.locked'],
            [
                'AND' => [
                    'status_company' => 3,
                    'operator' => $user
                ],
                'LIMIT' => [$offset, $limit],
                'ORDER' => ['id ASC']
            ]
        );

        return [
            'data' => $companyData,
            'count' => $countPage
        ];

    }

    public function getIncorrectCompany($user,$page=0)
    {
        $limit = PAGE_SIZE;
        $countData = $this->db->count('company', [
            'AND' => [
                'status_company' => 5,
                'operator' => $user
            ]
        ]);
        $countPage = ceil($countData / $limit);
        $offset = (int)$page * $limit;
        $companyData = $this->db->select("company", [
            "[>]status_type" => ["status_company" => "id"]
        ],
            [
                'company.id',
                'company.name',
                'company.ph_address',
                'company.date_create',
                'company.status_company',
                'status_type.name(status_name)',
                'company.location',
                'company.sale',
                'company.locked'],
            [
                'AND' => [
                    'status_company' => 5,
                    'operator' => $user
                ],
                'LIMIT' => [$offset, $limit],
                'ORDER' => ['id ASC']
            ]
        );

        return [
            'data' => $companyData,
            'count' => $countPage
        ];

    }

    public function getHassiteCompany($user,$page=0)
        {
            $limit = PAGE_SIZE;
            $countData = $this->db->count('company', [
                'AND' => [
                    'status_company' => 4,
                    'operator' => $user
                ]
            ]);
            $countPage = ceil($countData / $limit);
            $offset = (int)$page * $limit;
            $companyData = $this->db->select("company", [
                "[>]status_type" => ["status_company" => "id"]
            ],
                [
                    'company.id',
                    'company.name',
                    'company.ph_address',
                    'company.date_create',
                    'company.status_company',
                    'status_type.name(status_name)',
                    'company.location',
                    'company.sale',
                    'company.locked'],
                [
                    'AND' => [
                        'status_company' => 4,
                        'operator' => $user
                    ],
                    'LIMIT' => [$offset, $limit],
                    'ORDER' => ['id ASC']
                ]
            );

            return [
                'data' => $companyData,
                'count' => $countPage
            ];

        }

    public function getMeetCompany($user,$page=0)
                {
                    $limit = PAGE_SIZE;
                    $countData = $this->db->count('company', [
                        'AND' => [
                            'status_company' => 2,
                            'operator' => $user
                        ]
                    ]);
                    $countPage = ceil($countData / $limit);
                    $offset = (int)$page * $limit;
                    $companyData = $this->db->select("company", [
                        "[>]status_type" => ["status_company" => "id"]
                    ],
                        [
                            'company.id',
                            'company.name',
                            'company.ph_address',
                            'company.date_create',
                            'company.status_company',
                            'status_type.name(status_name)',
                            'company.location',
                            'company.sale',
                            'company.locked'],
                        [
                            'AND' => [
                                'status_company' => 2,
                                'operator' => $user
                            ],
                            'LIMIT' => [$offset, $limit],
                            'ORDER' => ['id ASC']
                        ]
                    );

                    return [
                        'data' => $companyData,
                        'count' => $countPage
                    ];

                }

    public function getEditCompany($user,$id)
    {
        $countData = $this->db->count('company', [
            'AND' => [
                'id' => $id,
                'operator' => $user
            ]
        ]);
        $countPage = $countData;
        $companyData = $this->db->select("company", [
            "[>]status_type" => ["status_company" => "id"]
        ],
        [
            "company.*",
            'status_type.name(status_name)',
        ],
            [
                'AND' => [
                    'company.id' => $id,
                    'company.operator' => $user
                ]
            ]
        )[0];

        $companyData['contact']=json_decode($companyData['contact']);
        $companyData['comment']=json_decode($companyData['comment']);

        return [
            'data' => $companyData,
            'count' => $countPage
        ];

    }


}