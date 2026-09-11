<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'company_id', 'position', 'description', 'qualifications',
        'city', 'latitude', 'longitude',
        'work_type', 'job_category', 'required_skills', 'min_education',
        'salary_min', 'salary_max', 'work_duration', 'work_hours',
        'contact_method', 'contact_whatsapp', 'contact_email',
        'radius_km', 'quota', 'status',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'salary_min'      => 'integer',
        'salary_max'      => 'integer',
        'quota'           => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function getWorkTypeLabelAttribute(): string
    {
        return match($this->work_type) {
            'full_time'  => 'Full-time',
            'part_time'  => 'Part-time',
            'harian'     => 'Harian',
            'kontrak'    => 'Kontrak',
            'internship' => 'Magang',
            default      => $this->work_type,
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match($this->job_category) {
            'fnb'          => 'bx bx-restaurant',
            'retail'       => 'bx bx-store-alt',
            'sales'        => 'bx bx-line-chart',
            'administrasi' => 'bx bx-file',
            'jasa'         => 'bx bx-smile',
            'kesehatan'    => 'bx bx-plus-medical',
            'otomotif'     => 'bx bx-car',
            'teknologi'    => 'bx bx-laptop',
            'logistik'     => 'bx bx-package',
            'konstruksi'   => 'bx bx-building',
            'produksi'     => 'bx bx-cog',
            'teknisi'      => 'bx bx-wrench',
            default        => 'bx bx-briefcase',
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match($this->job_category) {
            'fnb'          => '#ea580c', // Orange
            'retail'       => '#059669', // Emerald Green
            'sales'        => '#0284c7', // Sky Blue
            'administrasi' => '#2563eb', // Royal Blue
            'jasa'         => '#0891b2', // Cyan
            'kesehatan'    => '#e11d48', // Rose / Red
            'otomotif'     => '#475569', // Slate
            'teknologi'    => '#4f46e5', // Indigo
            'logistik'     => '#d97706', // Amber Gold
            'konstruksi'   => '#b45309', // Warm Bronze
            'produksi'     => '#7c3aed', // Purple
            'teknisi'      => '#0d9488', // Teal
            default        => '#475569', // Slate
        };
    }

    public function getCategoryBgAttribute(): string
    {
        return match($this->job_category) {
            'fnb'          => '#ffedd5',
            'retail'       => '#d1fae5',
            'sales'        => '#e0f2fe',
            'administrasi' => '#dbeafe',
            'jasa'         => '#cffafe',
            'kesehatan'    => '#ffe4e6',
            'otomotif'     => '#f1f5f9',
            'teknologi'    => '#e0e7ff',
            'logistik'     => '#fef3c7',
            'konstruksi'   => '#fed7aa',
            'produksi'     => '#ede9fe',
            'teknisi'      => '#ccfbf1',
            default        => '#f1f5f9',
        };
    }

    public function getCategoryNameAttribute(): string
    {
        return match($this->job_category) {
            'fnb'          => 'F&B / Kuliner',
            'retail'       => 'Retail & Toko',
            'sales'        => 'Sales & Marketing',
            'administrasi' => 'Administrasi & Kantor',
            'jasa'         => 'Jasa & Layanan',
            'kesehatan'    => 'Kesehatan & Medis',
            'otomotif'     => 'Otomotif',
            'teknologi'    => 'Teknologi & Digital',
            'logistik'     => 'Logistik & Gudang',
            'konstruksi'   => 'Konstruksi & Properti',
            'produksi'     => 'Pabrik & Garment',
            'teknisi'      => 'Teknisi',
            default        => ucfirst($this->job_category ?: 'Lainnya'),
        };
    }

    public function getSalaryRangeAttribute(): string
    {
        if (!$this->salary_min) return 'Negosiasi';
        $min = 'Rp' . number_format($this->salary_min, 0, ',', '.');
        if ($this->salary_max) {
            $max = 'Rp' . number_format($this->salary_max, 0, ',', '.');
            return "{$min}–{$max}/bulan";
        }
        return "{$min}/bulan";
    }

    public static function workTypes(): array
    {
        return [
            'full_time' => 'Full-time',
            'part_time' => 'Part-time',
            'harian'    => 'Harian',
            'kontrak'   => 'Kontrak',
        ];
    }

    public static function jobCategories(): array
    {
        return [
            'fnb'           => 'F&B (Makanan & Minuman)',
            'retail'        => 'Retail',
            'jasa'          => 'Jasa',
            'produksi'      => 'Produksi',
            'logistik'      => 'Logistik & Gudang',
            'konstruksi'    => 'Konstruksi',
            'administrasi'  => 'Administrasi',
            'teknisi'       => 'Teknisi',
            'lainnya'       => 'Lainnya',
        ];
    }
}
