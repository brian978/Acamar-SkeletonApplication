<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @package Aura.SqlQuery
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Aura\SqlQuery;

/**
 *
 * Abstract query object for data manipulation (Insert, Update, and Delete).
 *
 * @package Aura.SqlQuery
 *
 */
abstract class AbstractDmlQuery extends AbstractQuery
{
    /**
     *
     * Column values for INSERT or UPDATE queries; the key is the column name and the
     * value is the column value.
     *
     * @param array
     *
     */
    protected $col_values;

    /**
     *
     * The columns to be returned.
     *
     * @var array
     *
     */
    protected $returning = array();

    /**
     *
     * Gets the values to bind to placeholders, including any 'where' values
     * (needed for INSERT and UPDATE).
     *
     * @return array
     *
     */
    public function getBindValues()
    {
        $bind_values = parent::getBindValues();
        $i = 1;
        foreach ($this->bind_where as $val) {
            $bind_values[$i] = $val;
            $i ++;
        }
        return $bind_values;
    }

    /**
     *
     * Sets one column value placeholder; if an optional second parameter is
     * passed, that value is bound to the placeholder.
     *
     * @param string $col The column name.
     *
     * @param mixed $val Optional: a value to bind to the placeholder.
     *
     * @return self
     *
     */
    protected function addCol($col)
    {
        $key = $this->quoter->quoteName($col);
        $this->col_values[$key] = ":$col";
        $args = func_get_args();
        if (count($args) > 1) {
            $this->bindValue($col, $args[1]);
        }
        return $this;
    }

    /**
     *
     * Sets multiple column value placeholders. If an element is a key-value
     * pair, the key is treated as the column name and the value is bound to
     * that column.
     *
     * @param array $cols A list of column names, optionally as key-value
     * pairs where the key is a column name and the value is a bind value for
     * that column.
     *
     * @return self
     *
     */
    protected function addCols(array $cols)
    {
        foreach ($cols as $key => $val) {
            if (is_int($key)) {
                // integer key means the value is the column name
                $this->addCol($val);
            } else {
                // the key is the column name and the value is a value to
                // be bound to that column
                $this->addCol($key, $val);
            }
        }
        return $this;
    }

    /**
     *
     * Sets a column value directly; the value will not be escaped, although
     * fully-qualified identifiers in the value will be quoted.
     *
     * @param string $col The column name.
     *
     * @param string $value The column value expression.
     *
     * @return self
     *
     */
    protected function setCol($col, $value)
    {
        if ($value === null) {
            $value = 'NULL';
        }

        $key = $this->quoter->quoteName($col);
        $value = $this->quoter->quoteNamesIn($value);
        $this->col_values[$key] = $value;
        return $this;
    }

    /**
     *
     * Adds returning columns to the query.
     *
     * Multiple calls to returning() will append to the list of columns, not
     * overwrite the previous columns.
     *
     * @param array $cols The column(s) to add to the query.
     *
     * @return self
     *
     */
    protected function addReturning(array $cols)
    {
        foreach ($cols as $col) {
            $this->returning[] = $this->quoter->quoteNamesIn($col);
        }
        return $this;
    }

    /**
     *
     * Builds the `RETURNING` clause of the statement.
     *
     * @return string
     *
     */
    protected function buildReturning()
    {
        if (! $this->returning) {
            return ''; // not applicable
        }

        return PHP_EOL . 'RETURNING' . $this->indentCsv($this->returning);
    }
}
