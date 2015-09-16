<?php
namespace Cirici\MatchAgainstBundle\Extension\Doctrine\Query\Sqlite;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

class MatchAgainst extends FunctionNode {

    public $columns = array();
    public $needle;
    public $mode;

    public function parse(Parser $parser)
    {

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        do {
            $this->columns[] = $parser->StateFieldPathExpression();
            $parser->match(Lexer::T_COMMA);
        }
        while ($parser->getLexer()->isNextToken(Lexer::T_IDENTIFIER));

        $this->needle = $parser->InParameter();

        while ($parser->getLexer()->isNextToken(Lexer::T_STRING)) {
            $this->mode = $parser->Literal();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        $likes = array();

        foreach ($this->columns as $column) {
            $likes[] = $column->dispatch($sqlWalker) . ' LIKE ' . $this->needle->dispatch($sqlWalker);
        }

        $query = implode(' OR ', $likes);

        return $query;
    }
}
