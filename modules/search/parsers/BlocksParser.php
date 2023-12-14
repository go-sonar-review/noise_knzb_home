<?php

namespace modules\search\parsers;

use craft\elements\MatrixBlock;

use modules\search\parsers\LinkParser;

class BlocksParser implements FieldParser
{
    public static function parse($contentBlocks): array
    {
        $content = [];

        foreach ($contentBlocks as $block) {
            $content[] = self::parseType($block);
        }

        return ['content' => $content];
    }

    public static function parseType(MatrixBlock $block): array
    {
        $handle = $block->getType()->handle;

        switch ($handle) {
            case 'imageBlock':
                return ["imageBlock" => self::parseImageBlock($block)];
                break;

            case 'agendaBlock':
                return ["agendaBlock" => self::parseAgendaBlock($block)];
                break;
            
            case 'categoriesBlock':
                return ["categoriesBlock" => self::parseCategoriesBlock($block)];
                break;

            case 'contentCards':
                return ["contentCards" => self::parseContentCards($block)];
                break;

            case 'ctaBlock':
                return ["ctaBlock" => self::parseCTABlock($block)];
                break;

            case 'ctaList':
                return ["ctaList" => self::parseCTAList($block)];
                break;

            case 'embedBlock':
                return ["embedBlock" => self::parseEmbedBlock($block)];
                break;                

            case 'formBlock':
                return ["formBlock" => self::parseFormBlock($block)];
                break;

            case 'latestContentBlock':
                return ["latestContentBlock" => self::parseLatestContentBlock($block)];
                break;

            case 'partnersBlock':
                return ["partnersBlock" => self::parsePartnersBlock($block)];
                break;


            case 'peopleBlock':
                return ["peopleBlock" => self::parsePeopleBlock($block)];
                break;
            

            case 'quoteBlock':
                return ["quoteBlock" => self::parseQuoteBlock($block)];
                break;

            case 'textBlock':
                return ["textBlock" => self::parseTextBlock($block)];
                break;

            case 'textImageBlock':
                return ["textImageBlock" => self::parseTextImageBlock($block)];
                break;

            case 'featuredContentBlock':
                return ["featuredContentBlock" => self::parseFeaturedContentBlock($block)];
                break;

            case 'faqBlock':
                return ["faqBlock" => self::parseFaqBlock($block)];
                break;

            default:
                //throw new \RunTimeException('Unhandled MatrixBlock with handle ' . $handle);
                echo 'Skipping unhandled ContentBlock with handle "' . $handle . '"' . PHP_EOL;
                return [];
        }
    }

    public static function parseImageBlock(MatrixBlock $block): array
    {
        $image = $block->imageDesktop->one();

        if ($image) {
            return [
                'url' => $image->getUrl(),
                'caption' => $image->title
            ];
        }

        return [];
    }

    public static function parseAgendaBlock(MatrixBlock $block): array
    {
        return [
            'title' => $block->blockTitle,
            'ctas' => $block->ctas ? array_map(fn ($cta) => LinkParser::parse($cta->ctaItem), $block->ctas->all()) : [],
            'entries' =>  $block->entries ? array_map(fn ($entry) => [ 'title' => $entry->title, 'url' => $entry->url ? $entry-> url : null ], $block->entries->all()) : [],
            'featured'=> $block->featured ? array_map(fn ($entry) => [ 'title' => $entry->title, 'url' => $entry->url ? $entry-> url : null ], $block->featured->all()) : [],
            'image' => $block->imageDesktop->one() ? [ 
                'url' => $block->imageDesktop->one()->getUrl(), 
                'caption' => $block->imageDesktop->one()->title 
            ] : [],
            'categories' => $block->categories ? $block->categories->select('title')->column() : [],
        ];
    }

    public static function parseCategoriesBlock(MatrixBlock $block): array
    {
        return [
            'title' => $block->blockTitle,
            'sub-title'=> $block->firstPartTitle,
            'categories' => $block->categories ? array_map(fn ($entry) => [ 'title' => $entry->title, 'url' => $entry->url ? $entry-> url : null ], $block->categories->all()) : [],
        ];
    }

    public static function parseContentCards(MatrixBlock $block): array
    {
        if ($block->cards) {
            $cards = [];
            foreach ($block->cards as $card) {
                $cards[] = [
                    'title' => $card->blockTitle,
                    'text' => $card->blockText ? $card->blockText->getRawContent() : null,
                    'entries' => $block->blockEntry ? array_map(fn ($entry) => [ 'title' => $entry->title, 'url' => $entry->url ? $entry-> url : null ], $block->blockEntry->all()) : [],
                ];
            }
            return $cards;
        }
        return [];
    }

    public static function parseCTABlock(MatrixBlock $block): array
    {
        $data = [
            'title' => $block->blockTitle,
            'type' => $block->blockLinkType->value,
            'preTitle' => $block->blockPreTitle,
        ];

        return array_merge($data, LinkParser::parse($block->cta));
    }

    public static function parseCTAList(MatrixBlock $block): array
    {
        return [
            "title" => $block->blockTitle,
            "ctas" =>  $block->ctas ? array_map(fn ($cta) => [ LinkParser::parse($cta->cta) ], $block->ctas->all()) : [],
        ];
    }

    public static function parseEmbedBlock(MatrixBlock $block): array
    {
        return [
            "emebd" => $block->embed
        ];
    }

    public static function parseFormBlock(MatrixBlock $block): array
    {
        $form = $block->form->one();
        $details = $block->details->one();

        if ($form) {
            $data = [
                'form' => $form->title,
                'details' => []
            ];

            if ($details) {
                $data["details"] = [
                    "label" => $details->label,
                    "title" => $details->blockTitle,
                    "description" => $details->description,
                ];
            }

            return $data;
        }

        return [];
    }

    public static function parseLatestContentBlock(MatrixBlock $block): array
    {
        return [
            "title" => $block->blockTitle,
            'link' => LinkParser::parse($block->blockLink)
        ];
    }

    public static function parsePartnersBlock(MatrixBlock $block): array
    {
        return [
            'partners' => $block->partners ? array_map(fn ($entry) => [ 'title' => $entry->title, 'url' => $entry->url ? $entry-> url : null ], $block->partners->all()) : [],
        ];
    }

    public static function parsePeopleBlock(MatrixBlock $block): array
    {
        return [
            "rows" => $block->itemRows,
            "entries" => $block->entries ? array_map(fn ($entry) => [ 'title' => $entry->title ], $block->entries->all()) : [],
            "cta" => LinkParser::parse($block->cta)
        ];
    }

    public static function parseQuoteBlock(MatrixBlock $block): array
    {
        return [
            "quote" => $block->quote,
            'quotee' => $block->quotee
        ];
    }

    public static function parseTextBlock(MatrixBlock $block): array
    {
        return  [
            "title" => $block->blockTitle,
            "text" => $block->text ? $block->text->getRawContent() : null,
            "ctas" => $block->ctas ? array_map(fn ($cta) => LinkParser::parse($cta->cta), $block->ctas->all()) : []
        ];
    }

    public static function parseTextImageBlock(MatrixBlock $block): array
    {
        return  [
            "title" => $block->blockTitle,
            "description" => $block->description ? $block->description->getRawContent() : null,
            "ctas" => $block->ctas ? array_map(fn ($cta) => LinkParser::parse($cta->cta), $block->ctas->all()) : []
        ];
    }

    public static function parseFeaturedContentBlock(MatrixBlock $block): array
    {
        $data = [
            "title" => $block->blockTitle
        ];

        return array_merge($data, LinkParser::parse($block->blockLink));
    }

    public static function parseFaqBlock(MatrixBlock $block): array
    {
        return [
            "title" => $block->blockTitle,
            "questions" => $block->entries ? array_map(fn ($question) => [
                "question" => $question->question,
                "answer" => $question->answer ? $question->answer->getRawContent() : null,
            ], $block->entries->all()) : []
        ];
    }
}
