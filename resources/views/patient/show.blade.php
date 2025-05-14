
<x-layout>
  <x-navbar/>


  <section id="clinics" class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-teal-700 mb-4 text-center">Our Clinics</h2>

      {{-- Search Bar --}}
      <div class="mb-6">
        <input
          type="text"
          id="clinic-search"
          class="w-full px-4 py-2 border rounded-md"
          placeholder="Search clinics by name…"
          autocomplete="off"
        />
      </div>

      {{-- Grid --}}
      <div id="clinics-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($clinics as $clinic)
          <div class="bg-white rounded-lg shadow p-6">
            @if($clinic->image)
              <img src="{{ asset('storage/'.$clinic->image) }}"
                   class="w-full h-48 object-cover rounded-md mb-4">
            @endif
            <h3 class="text-xl font-semibold mb-1">{{ $clinic->name }}</h3>
            <p class="text-sm text-gray-600">{{ $clinic->description }}</p>
          </div>
        @endforeach
      </div>

      {{-- Pagination Links --}}
      <div id="clinics-pagination" class="mt-6">
        {{ $clinics->links() }}
      </div>
    </div>
  </section>

  {{-- Doctors Section --}}
  <section id="doctors" class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-teal-700 mb-4 text-center">Our Doctors</h2>

      {{-- Search Bar --}}
      <div class="mb-6">
        <input
          type="text"
          id="doctor-search"
          class="w-full px-4 py-2 border rounded-md"
          placeholder="Search doctors by name…"
          autocomplete="off"
        />
      </div>

      {{-- Grid --}}
      <div id="doctors-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($doctors as $doctor)
          <div class="bg-gray-50 rounded-lg shadow p-6">
            @if($doctor->image)
              <img src="{{ asset('storage/'.$doctor->image) }}"
                   class="w-full h-48 object-cover rounded-md mb-4">
            @endif
            <h3 class="text-xl font-semibold mb-1">
              {{ $doctor->first_name }} {{ $doctor->last_name }}
            </h3>
            <p class="text-sm text-gray-600">{{ $doctor->specialization }}</p>
          </div>
        @endforeach
      </div>

      {{-- Pagination Links --}}
      <div id="doctors-pagination" class="mt-6">
        {{ $doctors->links() }}
      </div>
    </div>
  </section>

  <x-footer/>

  <script>
    const clinicSearchUrl = "{{ route('search.clinics') }}";
    const doctorSearchUrl = "{{ route('search.doctors') }}";

    // cache originals
    const clinicListEl    = document.getElementById('clinics-list');
    const clinicPagEl     = document.getElementById('clinics-pagination');
    const originalClinics = clinicListEl.innerHTML;
    const originalClinicsPag = clinicPagEl.innerHTML;

    const doctorListEl    = document.getElementById('doctors-list');
    const doctorPagEl     = document.getElementById('doctors-pagination');
    const originalDoctors = doctorListEl.innerHTML;
    const originalDoctorsPag = doctorPagEl.innerHTML;

    // Clinics search
    document.getElementById('clinic-search')
      .addEventListener('input', function() {
        const q = this.value.trim();

        if (q === '') {
          clinicListEl.innerHTML = originalClinics;
          clinicPagEl.innerHTML  = originalClinicsPag;
          return;
        }

        if (q.length > 2) {
          fetch(`${clinicSearchUrl}?query=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(({clinics}) => {
              clinicListEl.innerHTML = '';
              clinics.forEach(c => {
                clinicListEl.innerHTML += `
                  <div class="bg-white rounded-lg shadow p-6">
                    ${c.image ?
                      `<img src="/storage/${c.image}" class="w-full h-48 object-cover rounded-md mb-4">`
                      : ''}
                    <h3 class="text-xl font-semibold mb-1">${c.name}</h3>
                    <p class="text-sm text-gray-600">${c.description}</p>
                  </div>`;
              });
              // hide pagination during search
              clinicPagEl.innerHTML = '';
            });
        }
      });

    // Doctors search
    document.getElementById('doctor-search')
      .addEventListener('input', function() {
        const q = this.value.trim();

        if (q === '') {
          doctorListEl.innerHTML = originalDoctors;
          doctorPagEl.innerHTML  = originalDoctorsPag;
          return;
        }

        if (q.length > 2) {
          fetch(`${doctorSearchUrl}?query=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(({doctors}) => {
              doctorListEl.innerHTML = '';
              doctors.forEach(d => {
                doctorListEl.innerHTML += `
                  <div class="bg-gray-50 rounded-lg shadow p-6">
                    ${d.image ?
                      `<img src="/storage/${d.image}" class="w-full h-48 object-cover rounded-md mb-4">`
                      : ''}
                    <h3 class="text-xl font-semibold mb-1">
                      ${d.first_name} ${d.last_name}
                    </h3>
                    <p class="text-sm text-gray-600">${d.specialization}</p>
                  </div>`;
              });
              // hide pagination during search
              doctorPagEl.innerHTML = '';
            });
        }
      });
  </script>
</x-layout>
