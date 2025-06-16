<?php

declare(strict_types=1);

namespace OliverThiele\OtIrrebuttons\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/***
 *
 * This file is part of the "IRRE Button" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2024-2025 Oliver Thiele <mail@oliver-thiele.de>, Web Development Oliver Thiele
 *
 ***/

/**
 * Domain Model Button
 */
class Button extends AbstractEntity
{
    /**
     * @var string
     */
    protected string $text = '';

    /**
     * @var string
     */
    protected string $link = '';

    /**
     * @var string
     */
    protected string $layout = '';

    /**
     * @var string
     */
    protected string $icon = '';

    /**
     * @var string
     */
    protected string $iconPosition = '';

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getIconPosition(): string
    {
        return $this->iconPosition;
    }

    /**
     * @param string $iconPosition
     */
    public function setIconPosition(string $iconPosition): void
    {
        $this->iconPosition = $iconPosition;
    }

}
