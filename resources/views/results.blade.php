<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Ruda:wght@400;600;700&display=swap");

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #37474f;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "poppins", sans-serif;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background-color: #232931;
            color: #fff;
            border-radius: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
        }

        .wrapper {
            display: grid;
            grid-template-columns: 3fr 4fr;
            grid-gap: 1rem;
        }

        img {
            width: 100%;
        }

        .img_section {
            border-radius: 25px;
            background-image: url("../img/bg.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            transform: scale(1.03) perspective(200px);
        }

        .img_section::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #5c6bc0 10%, #0d47a1 100%);
            opacity: 0.5;
            z-index: -1;
            border-radius: 25px;
        }

        .default_info {
            padding: 1.5rem;
            text-align: center;
        }

        .default_info img {
            width: 80%;
            object-fit: cover;
            margin: 0 auto;
        }

        .default_info h2 {
            font-size: 3rem;
        }

        .default_info h3 {
            font-size: 1.3rem;
            text-transform: capitalize;
        }

        .weather_temp {
            font-size: 4rem;
            font-weight: 800;
        }

        /* content section */
        .content_section {
            padding: 1.5rem;
        }

        .content_section form {
            margin: 1.5rem 0;
            position: relative;
        }

        .content_section form input {
            width: 84%;
            outline: none;
            background: transparent;
            border: 1px solid #37474f;
            border-radius: 5px;
            padding: 0.7rem 1rem;
            font-family: inherit;
            color: #fff;
            font-size: 1rem;
        }

        .content_section form button {
            position: absolute;
            top: 0;
            right: 0;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            padding: 1rem 0.7rem;
            font-family: inherit;
            font-size: 0.8rem;
            outline: none;
            border: none;
            background: #5c6bc0;
            color: #fff;
            cursor: pointer;
        }

        .day_info .content {
            display: flex;
            justify-content: space-between;
            padding: 0.4rem 0;
        }

        .day_info .content .title {
            font-weight: 600;
        }

        .list_content ul {
            display: flex;
            justify-content: space-between;
            align-items: center;
            list-style-type: none;
            margin: 3rem 0rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
        }

        .list_content ul li {
            padding: 0.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 1rem;
            transition: all 0.3s ease-in;
        }

        .list_content ul li:hover {
            transform: scale(1.1);
            background-color: #fff;
            color: #232931;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            cursor: pointer;
        }

        .list_content ul li img {
            width: 50%;
            object-fit: cover;
        }

        .icons {
            opacity: 1;
        }

        .icons.fadeIn {
            animation: 0.5s fadeIn forwards;
            animation-delay: 0.7s;
        }

        @keyframes fadeIn {
            to {
                transition: all 0.5s ease-in;
                opacity: 1;
            }
        }

        .autocomplete-container {
            margin-bottom: 20px;
        }

        .input-container {
            display: flex;
            position: relative;
        }

        .input-container input {
            flex: 1;
            outline: none;

            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 10px;
            padding-right: 31px;
            font-size: 16px;
            color: #fff;
            background-color: #232931;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0px 2px 10px 2px rgba(0, 0, 0, 0.35);
            border-top: none;
            background-color: #232931;

            z-index: 99;
            top: calc(100% + 2px);
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            color: #fff;
        }

        .autocomplete-items div:hover {
            /*when hovering an item:*/
            background-color: rgba(255, 255, 255, 0.1);
        }

        .autocomplete-items .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: rgba(255, 255, 255, 0.1);
        }

        .clear-button {
            color: rgba(255, 255, 255, 0.4);
            cursor: pointer;

            position: absolute;
            right: 5px;
            top: 0;

            height: 100%;
            display: none;
            align-items: center;
        }

        .clear-button.visible {
            display: flex;
        }

        .clear-button:hover {
            color: rgba(255, 255, 255, 0.6);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <div class="img_section">
                <div class="default_info">
                    <h2 class="default_day">{{ now()->format('l') }}</h2>
                    <span class="default_date">{{ now()->format('Y-m-d') }}</span>
                    <div class="icons">
                        <img src="{{ $iconUrl }}" alt="" />
                        <h2 class="weather_temp">{{ $temp }}°C</h2>
                        <h3 class="cloudtxt">{{ $weatherDescription }}</h3>
                    </div>
                </div>
            </div>
            <div class="content_section">
                <form action="{{ route('search') }}" method="post">
                    @csrf
                    <div class="autocomplete-container" id="autocomplete-container"></div>
                    {{-- <input hidden type="text" placeholder="Enter a city" name="city" /> --}}
                    <button type="submit">Search</button>
                </form>

                <div class="day_info">
                    <div class="content">
                        <p class="title">City</p>
                        <span class="value">{{ $city }}</span>
                    </div>
                    {{-- <div class="content">
                        <p class="title">Country Code</p>
                        <span class="value">{{ $country }}</span>
                    </div> --}}
                    <div class="content">
                        <p class="title">TEMP</p>
                        <span class="value">{{ $temp }}°C</span>
                    </div>
                    <div class="content">
                        <p class="title">HUMIDITY</p>
                        <span span class="value">{{ $humidity }}%</span>
                    </div>
                    <div class="content">
                        <p class="title">WIND SPEED</p>
                        <span class="value">{{ $wind }}Km/h</span>
                    </div>
                </div>
                <div class="list_content">
                    <ul>
                        <li>
                            <img src="{{ $icon0Url }}" />
                            <span>{{ date('l', strtotime('+1 day')) }}</span>
                            <span class="day_temp">{{ $day0Temp }}°C</span>
                        </li>
                        <li>
                            <img src="{{ $icon1Url }}" />
                            <span>{{ date('l', strtotime('+2 day')) }}</span>
                            <span class="day_temp">{{ $day1Temp }}°C</span>
                        </li>
                        <li>
                            <img src="{{ $icon2Url }}" />
                            <span>{{ date('l', strtotime('+3 day')) }}</span>
                            <span class="day_temp">{{ $day2Temp }}°C</span>
                        </li>
                        <li>
                            <img src="{{ $icon3Url }}" />
                            <span>{{ date('l', strtotime('+4 day')) }}</span>
                            <span class="day_temp">{{ $day3Temp }}°C</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <script>
        function addressAutocomplete(containerElement, callback, options) {

            const MIN_ADDRESS_LENGTH = 3;
            const DEBOUNCE_DELAY = 300;

            // create container for input element
            const inputContainerElement = document.createElement("div");
            inputContainerElement.setAttribute("class", "input-container");
            containerElement.appendChild(inputContainerElement);

            // create input element
            const inputElement = document.createElement("input");
            inputElement.setAttribute("type", "text");
            inputElement.setAttribute("name", "city");
            inputElement.setAttribute("placeholder", options.placeholder);
            inputContainerElement.appendChild(inputElement);

            const hiddenInput = document.createElement("input");
            hiddenInput.setAttribute("type", "hidden");
            hiddenInput.setAttribute("name", "placeID");
            inputContainerElement.appendChild(hiddenInput);
            
            // add input field clear button
            const clearButton = document.createElement("div");
            clearButton.classList.add("clear-button");
            addIcon(clearButton);
            clearButton.addEventListener("click", (e) => {
                e.stopPropagation();
                inputElement.value = '';
                callback(null);
                clearButton.classList.remove("visible");
                closeDropDownList();
            });
            inputContainerElement.appendChild(clearButton);

            /* We will call the API with a timeout to prevent unneccessary API activity.*/
            let currentTimeout;

            /* Save the current request promise reject function. To be able to cancel the promise when a new request comes */
            let currentPromiseReject;

            /* Focused item in the autocomplete list. This variable is used to navigate with buttons */
            let focusedItemIndex;

            /* Process a user input: */
            inputElement.addEventListener("input", function(e) {
                const currentValue = this.value;

                /* Close any already open dropdown list */
                closeDropDownList();


                // Cancel previous timeout
                if (currentTimeout) {
                    clearTimeout(currentTimeout);
                }

                // Cancel previous request promise
                if (currentPromiseReject) {
                    currentPromiseReject({
                        canceled: true
                    });
                }

                if (!currentValue) {
                    clearButton.classList.remove("visible");
                }

                // Show clearButton when there is a text
                clearButton.classList.add("visible");

                // Skip empty or short address strings
                if (!currentValue || currentValue.length < MIN_ADDRESS_LENGTH) {
                    return false;
                }

                /* Call the Address Autocomplete API with a delay */
                currentTimeout = setTimeout(() => {
                    currentTimeout = null;

                    /* Create a new promise and send geocoding request */
                    const promise = new Promise((resolve, reject) => {
                        currentPromiseReject = reject;

                        // The API Key provided is restricted to JSFiddle website
                        // Get your own API Key on https://myprojects.geoapify.com
                        const apiKey = "8e89b59a08874e689aabe50d1183594c";

                        var url =
                            `https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(currentValue)}&format=json&limit=5&apiKey=${apiKey}`;

                        fetch(url)
                            .then(response => {
                                currentPromiseReject = null;

                                // check if the call was successful
                                if (response.ok) {
                                    response.json().then(data => resolve(data));
                                } else {
                                    response.json().then(data => reject(data));
                                }
                            });
                    });

                    promise.then((data) => {
                        // here we get address suggestions
                        currentItems = data.results;

                        /*create a DIV element that will contain the items (values):*/
                        const autocompleteItemsElement = document.createElement("div");
                        autocompleteItemsElement.setAttribute("class", "autocomplete-items");
                        inputContainerElement.appendChild(autocompleteItemsElement);

                        /* For each item in the results */
                        data.results.forEach((result, index) => {
                            /* Create a DIV element for each element: */
                            const itemElement = document.createElement("div");
                            /* Set formatted address as item value */
                            itemElement.innerHTML = result.formatted;
                            autocompleteItemsElement.appendChild(itemElement);

                            /* Set the value for the autocomplete text field and notify: */
                            itemElement.addEventListener("click", function(e) {
                                inputElement.value = currentItems[index].formatted;
                                callback(currentItems[index]);
                                /* Close the list of autocompleted values: */
                                closeDropDownList();
                            });
                        });

                    }, (err) => {
                        if (!err.canceled) {
                            console.log(err);
                        }
                    });
                }, DEBOUNCE_DELAY);
            });

            /* Add support for keyboard navigation */
            inputElement.addEventListener("keydown", function(e) {
                var autocompleteItemsElement = containerElement.querySelector(".autocomplete-items");
                if (autocompleteItemsElement) {
                    var itemElements = autocompleteItemsElement.getElementsByTagName("div");
                    if (e.keyCode == 40) {
                        e.preventDefault();
                        /*If the arrow DOWN key is pressed, increase the focusedItemIndex variable:*/
                        focusedItemIndex = focusedItemIndex !== itemElements.length - 1 ? focusedItemIndex + 1 : 0;
                        /*and and make the current item more visible:*/
                        setActive(itemElements, focusedItemIndex);
                    } else if (e.keyCode == 38) {
                        e.preventDefault();

                        /*If the arrow UP key is pressed, decrease the focusedItemIndex variable:*/
                        focusedItemIndex = focusedItemIndex !== 0 ? focusedItemIndex - 1 : focusedItemIndex = (
                            itemElements.length - 1);
                        /*and and make the current item more visible:*/
                        setActive(itemElements, focusedItemIndex);
                    } else if (e.keyCode == 13) {
                        /* If the ENTER key is pressed and value as selected, close the list*/
                        e.preventDefault();
                        if (focusedItemIndex > -1) {
                            closeDropDownList();
                        }
                    }
                } else {
                    if (e.keyCode == 40) {
                        /* Open dropdown list again */
                        var event = document.createEvent('Event');
                        event.initEvent('input', true, true);
                        inputElement.dispatchEvent(event);
                    }
                }
            });

            function setActive(items, index) {
                if (!items || !items.length) return false;

                for (var i = 0; i < items.length; i++) {
                    items[i].classList.remove("autocomplete-active");
                }

                /* Add class "autocomplete-active" to the active element*/
                items[index].classList.add("autocomplete-active");

                // Change input value and notify
                inputElement.value = currentItems[index].formatted;
                hiddenInput.value = currentItems[index].place_id;
                callback(currentItems[index]);
            }

            function closeDropDownList() {
                const autocompleteItemsElement = inputContainerElement.querySelector(".autocomplete-items");
                if (autocompleteItemsElement) {
                    inputContainerElement.removeChild(autocompleteItemsElement);
                }

                focusedItemIndex = -1;
            }

            function addIcon(buttonElement) {
                const svgElement = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
                svgElement.setAttribute('viewBox', "0 0 24 24");
                svgElement.setAttribute('height', "24");

                const iconElement = document.createElementNS("http://www.w3.org/2000/svg", 'path');
                iconElement.setAttribute("d",
                    "M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"
                    );
                iconElement.setAttribute('fill', 'currentColor');
                svgElement.appendChild(iconElement);
                buttonElement.appendChild(svgElement);
            }

            /* Close the autocomplete dropdown when the document is clicked. 
              Skip, when a user clicks on the input field */
            document.addEventListener("click", function(e) {
                if (e.target !== inputElement) {
                    closeDropDownList();
                } else if (!containerElement.querySelector(".autocomplete-items")) {
                    // open dropdown list again
                    var event = document.createEvent('Event');
                    event.initEvent('input', true, true);
                    inputElement.dispatchEvent(event);
                }
            });
        }

        addressAutocomplete(document.getElementById("autocomplete-container"), (data) => {
            console.log("Selected option: ");
            console.log(data);
        }, {
            placeholder: "Enter an address here"
        });
    </script>
</body>

</html>
