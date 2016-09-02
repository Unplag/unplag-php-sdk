<?php namespace Unplag\Check;
use Unplag\Exception\CheckException;

/**
 * Class CheckParam
 */
class CheckParam
{
    const TYPE_MY_LIBRARY = "my_library";
    const TYPE_WEB = "web";
    const TYPE_EXTERNAL_DB = "external_database";
    const TYPE_DOC_VS_DOC = "doc_vs_docs";
    const TYPE_WEB_AND_MY_LIBRARY = "web_and_my_library";

    /**
     * @var array
     */
    protected static $typeMap =
        [
            self::TYPE_MY_LIBRARY,
            self::TYPE_WEB,
            self::TYPE_EXTERNAL_DB,
            self::TYPE_DOC_VS_DOC,
            self::TYPE_WEB_AND_MY_LIBRARY
        ];

    /**
     * @var int
     */
    protected $file_id;

    /**
     * @var array
     */
    protected $versus_files = [];
    protected $type;

    /**
     * @var string $callback_url
     */
    protected $callback_url;

    /**
     * @var bool $exclude_citations
     */
    protected $exclude_citations;

    /**
     * @var bool $exclude_references
     */
    protected $exclude_references;

    /**
     * CheckParam constructor.
     * @param $file_id
     */
    public function __construct($file_id)
    {

    }

    /**
     * Method setType description.
     * @param $type
     * @param array $versusFiles
     *
     * @return $this
     * @throws CheckException
     */
    public function setType($type, $versusFiles = null)
    {

        if( array_search($type, self::$typeMap) === false )
        {
            throw new CheckException(
                sprintf(
                    "<b>Set invalid type: '%s'</b>. Allowed check type is '%s'",
                    $type,
                    implode("', '", self::$typeMap)
                )
            );
        }



        return $this;
    }

    /**
     * Method setCallbackUrl description.
     * @param $url
     *
     * @return $this
     */
    public function setCallbackUrl($url)
    {
        $this->callback_url = $url;
        return $this;
    }

    /**
     * Method setExcludeCitations description.
     * @param $exclude_citations
     *
     * @return $this
     */
    public function setExcludeCitations($exclude_citations)
    {
        $this->exclude_citations = (bool) $exclude_citations;
        return $this;
    }

    /**
     * Method setExcludeReferences description.
     * @param $exclude_references
     *
     * @return $this
     */
    public function setExcludeReferences($exclude_references)
    {
        $this->exclude_references = (bool) $exclude_references;
        return $this;
    }









}