package methods;

public enum Currency {
    USD("USD"),
    PLN("PLN"),
    JPY("JPY"),
    EUR("EUR"),
    GBP("GBP"),
    RUB("RUB"),
    CZK("CZK");

    private String name;

     Currency(String name) {
        this.name = name;
    }

    public String getName() {
        return name;
    }

    public void setName() {
        this.name = name;
    }


}
