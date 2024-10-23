@extends('layouts.app')

@section('title', 'Report a Crime')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mb-4">Report a Crime</h1>
                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data"
                      id="complaintForm">
                    @csrf
                    <input type="hidden" name="anonymous" value="1">

                    @guest
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Anonymity</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="anonymousCheckbox"
                                           name="anonymous" value="0" {{ old('anonymous', 0) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="anonymousCheckbox">File Anonymously</label>
                                </div>
                            </div>
                        </div>

                        <div id="userInfoFields" style="display: none;">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Personal Information</h5>
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="addressFields" style="display: none;">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Address Information</h5>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="personCity" class="form-label">City</label>
                                        <input type="text" class="form-control" id="personCity" name="person_city" value="{{ old('person_city') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="personState" class="form-label">State</label>
                                        <input type="text" class="form-control" id="personState" name="person_state" value="{{ old('person_state') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="zip" class="form-label">Zip Code</label>
                                        <input type="text" class="form-control" id="zip" name="zip" value="{{ old('zip') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endguest

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Report Details</h5>

                            <h6 class="card-title mt-4">Where did this crime occur</h6>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="zip" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="zip" name="zip" value="{{ old('zip') }}" required>
                            </div>

                            <div class="mb-3 mt-4">
                                <label for="complaint_type" class="form-label">Type of Crime</label>
                                <select class="form-select" id="complaint_type" name="complaint_type" required>
                                    <option selected disabled>Select a category</option>
                                    <option value="Robbery" {{ old('complaint_type') == 'Robbery' ? 'selected' : '' }}>Robbery</option>
                                    <option value="Theft" {{ old('complaint_type') == 'Theft' ? 'selected' : '' }}>Theft</option>
                                    <option value="Burglary" {{ old('complaint_type') == 'Burglary' ? 'selected' : '' }}>Burglary</option>
                                    <option value="Murder" {{ old('complaint_type') == 'Murder' ? 'selected' : '' }}>Murder</option>
                                    <option value="Rape" {{ old('complaint_type') == 'Rape' ? 'selected' : '' }}>Rape</option>
                                    <option value="Assault" {{ old('complaint_type') == 'Assault' ? 'selected' : '' }}>Assault</option>
                                    <option value="Motor vehicle theft" {{ old('complaint_type') == 'Motor vehicle theft' ? 'selected' : '' }}>Motor vehicle theft</option>
                                    <option value="Arson" {{ old('complaint_type') == 'Arson' ? 'selected' : '' }}>Arson</option>
                                    <option value="Human Trafficking" {{ old('complaint_type') == 'Human Trafficking' ? 'selected' : '' }}>Human Trafficking</option>
                                    <option value="Forgery" {{ old('complaint_type') == 'Forgery' ? 'selected' : '' }}>Forgery</option>
                                    <option value="Fraud" {{ old('complaint_type') == 'Fraud' ? 'selected' : '' }}>Fraud</option>
                                    <option value="Embezzlement" {{ old('complaint_type') == 'Embezzlement' ? 'selected' : '' }}>Embezzlement</option>
                                    <option value="Stolen property" {{ old('complaint_type') == 'Stolen property' ? 'selected' : '' }}>Stolen property</option>
                                    <option value="Vandalism" {{ old('complaint_type') == 'Vandalism' ? 'selected' : '' }}>Vandalism</option>
                                    <option value="Weapons" {{ old('complaint_type') == 'Weapons' ? 'selected' : '' }}>Weapons</option>
                                    <option value="Sex offenses" {{ old('complaint_type') == 'Sex offenses' ? 'selected' : '' }}>Sex offenses</option>
                                    <option value="Prostitution" {{ old('complaint_type') == 'Prostitution' ? 'selected' : '' }}>Prostitution</option>
                                    <option value="Narcotics" {{ old('complaint_type') == 'Narcotics' ? 'selected' : '' }}>Narcotics</option>
                                    <option value="Offenses against the family and children" {{ old('complaint_type') == 'Offenses against the family and children' ? 'selected' : '' }}>Offenses against the family and children</option>
                                    <option value="Domestic violence" {{ old('complaint_type') == 'Domestic violence' ? 'selected' : '' }}>Domestic violence</option>
                                    <option value="Driving under the influence" {{ old('complaint_type') == 'Driving under the influence' ? 'selected' : '' }}>Driving under the influence</option>
                                    <option value="Disorderly conduct" {{ old('complaint_type') == 'Disorderly conduct' ? 'selected' : '' }}>Disorderly conduct</option>
                                    <option value="Vagrancy" {{ old('complaint_type') == 'Vagrancy' ? 'selected' : '' }}>Vagrancy</option>
                                    <option value="Curfew and loitering laws" {{ old('complaint_type') == 'Curfew and loitering laws' ? 'selected' : '' }}>Curfew and loitering laws</option>
                                    <option value="School Violence" {{ old('complaint_type') == 'School Violence' ? 'selected' : '' }}>School Violence</option>
                                    <option value="Bullying" {{ old('complaint_type') == 'Bullying' ? 'selected' : '' }}>Bullying</option>
                                    <option value="Other" {{ old('complaint_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="mb-3" id="custom_type_div" style="display: none;">
                                <label for="custom_type" class="form-label">if other, please specify</label>
                                <input type="text" class="form-control" id="custom_type" name="custom_type" value="{{ old('custom_type') }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="incident_date" class="form-label">Incident Date and Time</label>
                                <div style="max-width: 250px; display: inline-block;">
                                    <input type="datetime-local" class="form-control" id="incident_date" name="incident_date" value="{{ old('incident_date') }}" required>
                                </div>
                            </div>

                            <h5 class="card-title mt-5">Accused Information</h5>
                            <p>If you know the details of the accused, please input it here</p>
                            <div class="mb-3">
                                <label for="officer_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="officer_name" name="officer_name" value="{{ old('officer_name') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="officer_address" name="officer_address" value="{{ old('officer_address') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_phone_number" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="officer_phone_number" name="officer_phone_number" value="{{ old('officer_phone_number') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="officer_email" name="officer_email" value="{{ old('officer_email') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_race" class="form-label">Race</label>
                                <input type="text" class="form-control" id="officer_race" name="officer_race" value="{{ old('officer_race') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_eye_color" class="form-label">Eye Color</label>
                                <input type="text" class="form-control" id="officer_eye_color" name="officer_eye_color" value="{{ old('officer_eye_color') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_weight" class="form-label">Weight</label>
                                <input type="text" class="form-control" id="officer_weight" name="officer_weight" value="{{ old('officer_weight') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_height" class="form-label">Height</label>
                                <input type="text" class="form-control" id="officer_height" name="officer_height" value="{{ old('officer_height') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_nickname" class="form-label">Nickname</label>
                                <input type="text" class="form-control" id="officer_nickname" name="officer_nickname" value="{{ old('officer_nickname') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="officer_date_of_birth" name="officer_date_of_birth" value="{{ old('officer_date_of_birth') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_work_location" class="form-label">Work Location</label>
                                <input type="text" class="form-control" id="officer_work_location" name="officer_work_location" value="{{ old('officer_work_location') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_gender" class="form-label">Gender</label>
                                <input type="text" class="form-control" id="officer_gender" name="officer_gender" value="{{ old('officer_gender') }}">
                            </div>
                            <div class="mb-3">
                                <label for="officer_age" class="form-label">Age</label>
                                <input type="text" class="form-control" id="officer_age" name="officer_age" value="{{ old('officer_age') }}">
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Witness(es) Information</h5>
                            <div id="witnesses" class="row">
                                <div class="witness row mb-3">
                                    <div class="witness mb-3 col-md-4">
                                        <label for="witness_name_0" class="form-label">Witness Name</label>
                                        <input type="text" class="form-control" id="witness_name_0" name="witnesses[0][name]" value="{{ old('witnesses.0.name') }}">
                                    </div>
                                    <div class="witness mb-3 col-md-3">
                                        <label for="witness_contact_0" class="form-label">Contact Number</label>
                                        <input type="tel" class="form-control" id="witness_contact_0" name="witnesses[0][contact]" value="{{ old('witnesses.0.contact') }}">
                                    </div>
                                    <div class="witness mb-3 col-md-3">
                                        <label for="witness_email_0" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="witness_email_0" name="witnesses[0][email]" value="{{ old('witnesses.0.email') }}">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                                        <button type="button" class="btn btn-danger delete-witness">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="addWitness">Add Another Witness</button>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Attachments</h5>
                            <div class="mb-3">
                                <label for="attachments" class="form-label">Upload Files (Images, Videos,
                                    Documents)</label>
                                <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 10px;
            background-color: #ffffff;
        }

        .form-check-input {
            width: 16px;
            height: 16px;
        }

        .select2-selection__rendered {
            line-height: 31px !important;
        }
        .select2-container .select2-selection--single {
            height: 35px !important;
        }
        .select2-selection__arrow {
            height: 34px !important;
        }
    </style>

    <script>
      // In your Javascript (external .js resource or <script> tag)
      $(document).ready(function() {
        $('#city').select2();

        let statesData = @json($states);

        const stateSelect = document.getElementById('state');
        const citySelect = document.getElementById('city');

        stateSelect.addEventListener('change', function () {
          const stateId = this.value;
          citySelect.innerHTML = '<option selected disabled>Select a city</option>';
          citySelect.disabled = true;

          const selectedState = statesData.find(state => state.id == stateId);
          if (selectedState) {
            selectedState.cities.forEach(city => {
              const option = document.createElement('option');
              option.value = city.id;
              option.textContent = city.name;
              citySelect.appendChild(option);
            });
            citySelect.disabled = false;
          }
        });

        document.getElementById('complaint_type').addEventListener('change', function () {
          var customTypeDiv = document.getElementById('custom_type_div');
          if (this.value === 'Other') {
            customTypeDiv.style.display = 'block';
          } else {
            customTypeDiv.style.display = 'none';
            document.getElementById('custom_type').value = ''; // Clear the custom type input
          }
        });

          @guest
          document.getElementById('anonymousCheckbox').addEventListener('change', function () {
            var userInfoFields = document.getElementById('userInfoFields');
            var addressFields = document.getElementById('addressFields');
            if (this.checked) {
              userInfoFields.style.display = 'none'; // Hide user info fields if anonymous
              addressFields.style.display = 'none'; // Hide address fields if anonymous
              // Clear the values of the user info and address fields
              document.getElementById('first_name').value = '';
              document.getElementById('last_name').value = '';
              document.getElementById('phone').value = '';
              document.getElementById('email').value = '';
              document.getElementById('password').value = '';
              document.getElementById('address').value = '';
              document.getElementById('city').value = '';
              document.getElementById('state').value = '';
              document.getElementById('zip').value = '';
            } else {
              userInfoFields.style.display = 'block'; // Show user info fields if not anonymous
              addressFields.style.display = 'block'; // Show address fields if not anonymous
              // The hidden input will ensure that anonymous is set to 0
            }
          });

        document.getElementById('complaintForm').addEventListener('submit', function (e) {
          console.log('Form action:', this.action); // Log the form action URL
          console.log('Anonymous value:', document.querySelector('input[name="anonymous"]').value); // Log the anonymous value

          var anonymous = document.getElementById('anonymousCheckbox').checked;
          if (!anonymous) {
            var requiredFields = ['first_name', 'last_name', 'phone', 'email', 'password', 'address', 'city', 'state', 'zip'];
            for (var i = 0; i < requiredFields.length; i++) {
              var field = document.getElementById(requiredFields[i]);
              if (!field.value) {
                e.preventDefault(); // Prevent form submission only if validation fails
                alert('Please fill in all required fields.'); // Alert user
                return; // Exit the function
              }
            }
          }
          console.log('Form is valid, submitting...'); // Log for debugging
          // Form will submit normally if all validations pass
        });
          @endguest
      });

      let witnessIndex = 1;
      document.getElementById('addWitness').addEventListener('click', function() {
        const witnessesDiv = document.getElementById('witnesses');
        const newWitnessDiv = document.createElement('div');
        newWitnessDiv.classList.add('witness', 'row', 'mb-3');
        newWitnessDiv.innerHTML = `
                <div class="col-md-4">
                    <label for="witness_name_${witnessIndex}" class="form-label">Witness Name</label>
                    <input type="text" class="form-control" id="witness_name_${witnessIndex}" name="witnesses[${witnessIndex}][name]">
                </div>
                <div class="col-md-3">
                    <label for="witness_contact_${witnessIndex}" class="form-label">Contact Number</label>
                    <input type="tel" class="form-control" id="witness_contact_${witnessIndex}" name="witnesses[${witnessIndex}][contact]">
                </div>
                <div class="col-md-3">
                    <label for="witness_email_${witnessIndex}" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="witness_email_${witnessIndex}" name="witnesses[${witnessIndex}][email]">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-center">
                    <button type="button" class="btn btn-danger delete-witness">Delete</button>
                </div>
            `;
        witnessesDiv.appendChild(newWitnessDiv);
        witnessIndex++;
      });

      document.getElementById('witnesses').addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-witness')) {
          event.target.closest('.witness').remove();
        }
      });
    </script>
@endsection

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
