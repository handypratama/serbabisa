<x-frontend-layout>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Current Weather</h1>
                    <p><strong>City:</strong> {{ $data['name'] }}</p>
                    <p><strong>Temperature:</strong> {{ $data['main']['temp'] }} &deg;F</p>
                    <p><strong>Humidity:</strong> {{ $data['main']['humidity'] }}%</p>
                    <p><strong>Wind Speed:</strong> {{ $data['wind']['speed'] }} mph</p>
                </div>
            </div>
        </div>
    </div>
</div>

</x-frontend-layout>