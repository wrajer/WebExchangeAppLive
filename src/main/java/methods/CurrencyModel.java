package methods;

public class CurrencyModel {


    private double ratetoeur;

    public double getRatetoeur() {
        return CurrencyConverter.convert(Currency.EUR, Currency.PLN);
    }
}
