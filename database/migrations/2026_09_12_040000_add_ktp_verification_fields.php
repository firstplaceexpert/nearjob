<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Extend users table
        if (!Schema::hasColumn('users', 'is_verified')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_verified')->default(false)->after('date_of_birth');
            });
        }

        // Extend companies table
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'ktp_path')) {
                $table->string('ktp_path')->nullable()->after('nib');
            }
            if (!Schema::hasColumn('companies', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('ktp_path');
            }
        });

        // Extend applicant_profiles table
        Schema::table('applicant_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('applicant_profiles', 'ktp_path')) {
                $table->string('ktp_path')->nullable()->after('cover_picture');
            }
            if (!Schema::hasColumn('applicant_profiles', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('ktp_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_verified')) {
                $table->dropColumn('is_verified');
            }
        });

        Schema::table('companies', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('companies', 'ktp_path')) $cols[] = 'ktp_path';
            if (Schema::hasColumn('companies', 'is_verified')) $cols[] = 'is_verified';
            if (!empty($cols)) $table->dropColumn($cols);
        });

        Schema::table('applicant_profiles', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('applicant_profiles', 'ktp_path')) $cols[] = 'ktp_path';
            if (Schema::hasColumn('applicant_profiles', 'is_verified')) $cols[] = 'is_verified';
            if (!empty($cols)) $table->dropColumn($cols);
        });
    }
};
