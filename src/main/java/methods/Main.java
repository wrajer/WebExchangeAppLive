package methods;
import java.math.BigDecimal;
import java.math.MathContext;
import java.math.RoundingMode;

public class Main {

    public static void main(String[] args) {
        System.out.println("Welcome to our International Exchange Office!");

        ExchangeOffice wallet1= new ExchangeOffice();
        wallet1.showFunds();

        wallet1.exchange(1000.0, Currency.PLN, Currency.EUR);

        wallet1.exchange(250.0, Currency.PLN, Currency.RUB);

        wallet1.exchange(501.0, Currency.JPY, Currency.USD);

    }
}
