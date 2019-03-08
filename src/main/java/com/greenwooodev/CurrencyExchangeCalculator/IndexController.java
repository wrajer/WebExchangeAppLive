package com.greenwooodev.CurrencyExchangeCalculator;

import methods.Currency;
import methods.CurrencyConverter;
import methods.CurrencyModel;
import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;

@Controller
public class IndexController {

     //   private CurrencyConverter convert = new CurrencyConverter();
    @GetMapping("/")
    public String index(@RequestParam(required = false) String amountfrom,
                        @RequestParam(required = false) String from,
                        @RequestParam(required = false) String to,
                        ModelMap modelMap) {

        if (amountfrom!=null && from!=null && to!=null && amountfrom!="") {
            modelMap.put("valueto", Double.parseDouble(amountfrom) * CurrencyConverter.convert(Currency.valueOf(from), Currency.valueOf(to)));
            modelMap.put("amountfrom", amountfrom);
            modelMap.put("from", from);
            modelMap.put("to", to);
        }

        //rates to table
        modelMap.put("currency", new CurrencyModel());
        modelMap.put("ratetogbp", CurrencyConverter.convert(Currency.GBP, Currency.PLN));
        modelMap.put("ratetousd", CurrencyConverter.convert(Currency.USD, Currency.PLN));
        modelMap.put("ratetorub", CurrencyConverter.convert(Currency.RUB, Currency.PLN));
        modelMap.put("ratetojpy", CurrencyConverter.convert(Currency.JPY, Currency.PLN));
        modelMap.put("ratetoczk", CurrencyConverter.convert(Currency.CZK, Currency.PLN));

        return "index";
    }
}
