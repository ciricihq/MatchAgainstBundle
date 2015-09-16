<?php
/**
 * AddFulltextIndexesCommand.php
 *
 * @author Jérémy Hubert <jeremy.hubert@infogroom.fr>
 * @since lun. 26 sept. 2011 09:23:53
 */
namespace Cirici\MatchAgainstBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\ConsoleInput\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class AddFulltextIndexesCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('matchagainst:build-fulltext');
        $this->setDescription('Create the search index to perform FULLTEXT');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getContainer()->get('doctrine')->getConnection();

        $dialog = $this->getDialogHelper();

        $database = $connection->getDatabase();
        $dialog->writeSection($output, 'Creating index for the table search_text_index ');
        $connection->query("ALTER TABLE `$database`.`search_text_index` ADD FULLTEXT `search_indexes` ( `content` )");

        $dialog->writeSection($output, 'Finished.');
    }

    protected function getDialogHelper()
    {
        $dialog = $this->getHelperSet()->get('dialog');
        if (!$dialog || get_class($dialog) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper') {
            $this->getHelperSet()->set($dialog = new DialogHelper());
        }

        return $dialog;
    }
}
