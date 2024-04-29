<?php

namespace App\Command;

use App\Service\JsonPlaceholderService;
use App\Service\DataSaverService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchJsonPlaceholderPostsCommand extends Command
{
    protected static $defaultName = 'app:fetch-json-placeholder-posts';

    private $jsonPlaceholderService;
    private $dataSaverService;

    public function __construct(JsonPlaceholderService $jsonPlaceholderService, DataSaverService $dataSaverService)
    {
        parent::__construct();
        $this->jsonPlaceholderService = $jsonPlaceholderService;
        $this->dataSaverService = $dataSaverService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetches data from JsonPlaceholder and saves it locally.')
            ->setHelp('This command allows you to fetch posts from JsonPlaceholder API and save them to a local file');
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting data fetch...');
        $data = $this->jsonPlaceholderService->getPosts(); // Assuming fetchData returns an array of data

        $output->writeln('Saving data...');
        try {
            $this->dataSaverService->saveDataToFile($data, 'posts.json');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $output->writeln('Data fetched and saved successfully.');

        return Command::SUCCESS;
    }
}
