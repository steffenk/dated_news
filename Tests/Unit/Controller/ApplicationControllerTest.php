<?php

namespace FalkRoeder\DatedNews\Tests\Unit\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Falk Röder <mail@falk-roeder.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class FalkRoeder\DatedNews\Controller\ApplicationController.
 *
 * @author Falk Röder <mail@falk-roeder.de>
 */
class ApplicationControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \FalkRoeder\DatedNews\Controller\ApplicationController
     */
    protected $subject = null;

    public function setUp()
    {
        $this->subject = $this->getMock('FalkRoeder\\DatedNews\\Controller\\ApplicationController', ['redirect', 'forward', 'addFlashMessage'], [], '', false);
    }

    public function tearDown()
    {
        unset($this->subject);
    }
}
