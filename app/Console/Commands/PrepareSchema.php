<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDOException;
use PDO;

class PrepareSchema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prepare:schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'prepares the database schema given in .env.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws \Exception
     * @throws \PDOException
     * @return mixed
     */
    public function handle()
    {
        try {
            $pdo = $this->getPDOConnection(
                env('DB_HOST'),
                env('DB_PORT'),
                env('DB_USERNAME'),
                env('DB_PASSWORD')
            );

            $command = sprintf(
                'CREATE DATABASE IF NOT EXISTS %s DEFAULT CHARACTER SET %s COLLATE %s;',
                env('DB_DATABASE'),
                env('DB_CHARSET'),
                env('DB_COLLATION')
            );

            $this->output->block('!! Executing query !!');
            $this->output->block($command);

            $pdo->exec($command);

            $this->output->block(
                sprintf('!! Successfully created %s database !!', env('DB_DATABASE'))
            );
        } catch (PDOException $exception) {
            $this->error(
                sprintf('Failed to create %s database, %s', env('DB_DATABASE'), $exception->getMessage())
            );
        }
    }

    /**
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @return \PDO
     */
    private function getPDOConnection($host, $port, $username, $password)
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }
}
