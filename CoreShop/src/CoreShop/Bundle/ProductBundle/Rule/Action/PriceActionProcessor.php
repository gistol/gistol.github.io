<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2017 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
*/

namespace CoreShop\Bundle\ProductBundle\Rule\Action;

use CoreShop\Component\Currency\Context\CurrencyContextInterface;
use CoreShop\Component\Currency\Converter\CurrencyConverterInterface;
use CoreShop\Component\Currency\Repository\CurrencyRepositoryInterface;
use CoreShop\Component\Product\Rule\Action\ProductPriceActionProcessorInterface;

class PriceActionProcessor implements ProductPriceActionProcessorInterface
{
    /**
     * @var CurrencyConverterInterface
     */
    protected $moneyConverter;

    /**
     * @var CurrencyRepositoryInterface
     */
    protected $currencyRepository;

    /**
     * @var CurrencyContextInterface
     */
    protected $currencyContext;

    /**
     * @param CurrencyRepositoryInterface $currencyRepository
     * @param CurrencyConverterInterface $moneyConverter
     * @param CurrencyContextInterface $currencyContext
     */
    public function __construct(CurrencyRepositoryInterface $currencyRepository, CurrencyConverterInterface $moneyConverter, CurrencyContextInterface $currencyContext)
    {
        $this->currencyRepository = $currencyRepository;
        $this->moneyConverter = $moneyConverter;
        $this->currencyContext = $currencyContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getDiscount($subject, $price, array $configuration)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice($subject, array $configuration)
    {
        $price = $configuration['price'];
        $currency = $this->currencyRepository->find($configuration['currency']);

        return $this->moneyConverter->convert($price, $currency->getIsoCode(), $this->currencyContext->getCurrency()->getIsoCode());
    }
}
