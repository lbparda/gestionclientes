    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('documentacionexp', function (Blueprint $table) {
                // Esta línea crea la clave primaria auto-incremental
                $table->id('IdEscrito');

                $table->string('NºExpediente');
                $table->string('Ruta', 512);
                $table->string('Escritos')->nullable();
                $table->string('Resumen')->nullable();
                $table->string('Tipo')->nullable();
                $table->string('FechaEscrito')->nullable();
                $table->string('FechaEs')->nullable();

                $table->foreign('NºExpediente')->references('NºExpediente')->on('Expedientes')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('documentacionexp');
        }
    };

