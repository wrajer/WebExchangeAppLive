package methods;
import java.math.BigDecimal;
import java.math.MathContext;
import java.math.RoundingMode;
import java.util.HashMap;
import java.util.Map;

public class  ExchangeOffice {

    private Map<Currency, BigDecimal> wallet = new HashMap<>();
    private BigDecimal startValue = new BigDecimal("10000");
    private double interest = 0.2;

    public ExchangeOffice() {
        for (Currency currency : Currency.values()) {
            wallet.put(currency, startValue);
        }
    }

    private String getValue(BigDecimal bigDecimal) {
        return bigDecimal.round(new MathContext(7, RoundingMode.HALF_UP)).toString();
    }

    public void showFunds() {
        System.out.print("Current founds: ");

        for (Currency name : wallet.keySet()) {
            String key = name.toString();
            String value = getValue(wallet.get(name));
            System.out.print(value + " " + key + " ");
        }
        System.out.println("\n");

    }

    public void exchange(double amount, Currency from, Currency to) {

        BigDecimal toAdd = new BigDecimal(amount * (1.0-interest)).multiply(BigDecimal.valueOf(CurrencyConverter.convert(from, to)));
        BigDecimal toTake = new BigDecimal(amount * (-1.0));

        if (checkIfEnoughFounds(amount, from)) {
            System.out.println("Exchanging " + amount + " " + from.getName() + " to " + getValue(toAdd) + " " + to.getName());
            wallet.put(to, wallet.get(to).add(toAdd));
            wallet.put(from, wallet.get(from).add(toTake));
        } else {
            System.out.println("Cannot exchange " + amount + " " + from.getName() + " to " + getValue(toAdd) + " " + to.getName() + " : insufficient funds.");
        }
        showFunds();
    }

    private boolean checkIfEnoughFounds(double amount, Currency from) {

        if (wallet.get(from).compareTo(BigDecimal.valueOf(amount)) >= 0) {
            return true;
        }

        return false;
    }
}

