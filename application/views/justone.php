<div class="row">
Le Reciept
    <p> Order For {customer} ({ordertype})</p>
    <ul style="list-style-type:none">
        {burgers}
            <p> Le Burger de mange</p>
            <li>
                <ul>

                    <li>Patty: {patty} </li>

                    <li>Cheeses: {cheese}</li>

                    <li>Topping:
                    {toppings}
                        {topping}
                    {/toppings} </li>

                    <li>Sauces:
                    {sauces}
                        {sauce}
                    {/sauces} </li>

                </ul>
            </li>
            <li> {name} </li>
            <li> {instructions} </li>

        {/burgers}
    </ul>
</div>