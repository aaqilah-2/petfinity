<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: row;
            max-width: 1200px;
            width: 100%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .leftSection {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .rightSection {
            flex: 1.5;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
            border-left: 1px solid #ddd;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
            display: flex;
        }

        ul li {
            margin: 10px;
            cursor: pointer;
        }

        ul li img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .addContainer img {
            width: 100px;
            height: 100px;
        }

        p {
            color: gray;
        }

        .btn {
            background-color: #5cb85c;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }

        .petProfile {
            display: none;
            flex-direction: column;
            align-items: flex-start;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
        }

        .petProfile.active {
            display: flex;
        }

        .petProfile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .petProfile h3, .petProfile button {
            margin: 10px 0;
        }

        .petProfile button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
        }

        .conditional-input {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="leftSection">
        <div class="petSection">
            <h2>Your Pets</h2>
            <ul>
                @foreach($pets as $pet)
                    <li data-pet-id="{{ $pet->id }}" onclick="showPetProfile({{ $pet->id }})">
                        <img src="{{ asset('uploads/pets/'.$pet->photo) }}" alt="{{ $pet->pet_name }}">
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="addContainer">
            <img src="{{ asset('add-pet.png') }}" alt="Add Pet">
            <h1>Add your pets</h1>
            <p>Manage your pet's profiles easily and keep their information up-to-date.</p>
            <a href="{{ route('pettype') }}" class="btn">Add Pet</a>
            <span>NOTE: You can add multiple pets.</span>
        </div>
    </div>

    <div class="rightSection">
        <div class="petProfile" id="petProfile">
            <form id="petForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center mb-4 image-upload-container">
                    <img src="{{ asset('images/puppyui.png') }}" alt="Pet Avatar" id="petAvatar">
                    <input type="file" id="petPhoto" name="photo" accept="image/*" onchange="previewImage(event)">
                    <label for="petPhoto" class="upload-icon">
                        <img src="{{ asset('images/images.png') }}" alt="Upload Icon" width="24" height="24">
                    </label>
                </div>

                <div class="mt-4">
                    <x-label for="pet_name" value="Pet Name" />
                    <x-input id="pet_name" class="block mt-1 w-full" type="text" name="pet_name" placeholder="Enter pet's name" required />
                </div>

                {{-- <input type="hidden" name="type" value=""> --}}

                <div class="mt-4">
                    <x-label for="breed" value="Breed" />
                    <x-input id="breed" class="block mt-1 w-full" type="text" name="breed" placeholder="Enter pet's breed" required />
                </div>

                <div class="form-group">
                    <label>Do you know your pet's age?</label>
                    <div class="toggle-switch">
                        <input type="radio" name="know_age" id="toggle-no" value="no">
                        <label for="toggle-no">No</label>
                        <input type="radio" name="know_age" id="toggle-yes" value="yes">
                        <label for="toggle-yes">Yes</label>
                        <div class="toggle-switch-background"></div>
                    </div>
                </div>

                <div id="input-for-no" class="conditional-input">
                    <label for="estimatedAge">Estimated Age</label>
                    <select class="form-control" id="estimatedAge" name="estimated_age">
                        <option value="< 6 months"> < 6 months </option>
                        <option value="6-12 months"> 6 - 12 months </option>
                        <option value="1-2 years">1 - 2 years</option>
                        <option value="2-4 years">2 - 4 years</option>
                        <option value="4-6 years">4 - 6 years</option>
                        <option value="6-8 years">6 - 8 years</option>
                        <option value="8-10 years">8 - 10 years</option>
                        <option value="10-15 years">10 - 15 years</option>
                        <option value=" > 15 years"> > 15 years</option>
                    </select>
                </div>
    
                <div id="input-for-yes" class="conditional-input" style="display: none;">
                    <label for="age">Exact Age (in years)</label>
                    <input type="string" step="0.1" class="form-control" id="age" name="exact_age" placeholder="Enter pet's age in years">
                </div>

                <div class="mt-4">
                    <x-label for="isCastrated" value="Is Castrated" />
                    <select id="isCastrated" class="block mt-1 w-full" name="is_castrated" required>
                        <option value="not_specified">Not specified</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div> 
                
                <div class="mt-4">
                    <x-label for="gender" value="Gender" />
                    <select id="gender" class="block mt-1 w-full" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="mt-4">
                    <x-label for="weight" value="Weight (in kg)" />
                    <x-input id="weight" class="block mt-1 w-full" type="number" step="0.1" name="weight" placeholder="Enter pet's weight" required />
                </div>

                <div class="mt-4">
                    <x-label for="height" value="Height (in cm)" />
                    <x-input id="height" class="block mt-1 w-full" type="number" step="0.1" name="height" placeholder="Enter pet's height" required />
                </div>

                <div class="mt-4">
                    <x-label for="medicalConditions" value="Medical Conditions" />
                
                    <div class="block mt-1 w-full">
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="allergies"> Allergies
                        </label><br>
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="arthritis"> Arthritis
                        </label><br>
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="diabetes"> Diabetes
                        </label><br>
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="epilepsy"> Epilepsy
                        </label><br>
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="heart_disease"> Heart Disease
                        </label><br>
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="hip_dysplasia"> Hip Dysplasia
                        </label><br>
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="respiratory_issues"> Respiratory Issues
                        </label><br>
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="skin_conditions"> Skin Conditions
                        </label><br>
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="kidney_disease"> Kidney Disease
                        </label><br>
                        <label>
                            <input type="checkbox" name="medical_conditions[]" value="felv"> Feline Leukemia Virus (FeLV)
                        </label><br>
                    </div>
                
                    <div class="mt-4">
                        <x-label for="otherMedicalConditions" value="Other Medical Conditions" />
                        <textarea id="medicalConditions" class="block mt-1 w-full" name="medical_conditions[]" rows="3" placeholder="Enter any other medical conditions"></textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <x-label for="dietaryRestrictions" value="Dietary Restrictions" />
                
                    <div class="block mt-1 w-full">
                        <label>
                            <input type="checkbox" name="dietary_restrictions[]" value="grain_free"> Grain-Free
                        </label><br>
                        <label>
                            <input type="checkbox" name="dietary_restrictions[]" value="gluten_free"> Gluten-Free
                        </label><br>
                        <label>
                            <input type="checkbox" name="dietary_restrictions[]" value="low_fat"> Low-Fat
                        </label><br>
                        <label>
                            <input type="checkbox" name="dietary_restrictions[]" value="high_protein"> High-Protein
                        </label><br>
                        <label>
                            <input type="checkbox" name="dietary_restrictions[]" value="no_chicken"> No Chicken
                        </label><br>
                        <label>
                            <input type="checkbox" name="dietary_restrictions[]" value="no_beef"> No Beef
                        </label><br>
                        <label>
                            <input type="checkbox" name="dietary_restrictions[]" value="hypoallergenic"> Hypoallergenic
                        </label><br>
                        <label>
                            <input type="checkbox" name="dietary_restrictions[]" value="raw_diet"> Raw Diet
                        </label><br>
                        <label>
                            <input type="checkbox" name="dietary_restrictions[]" value="vegan"> Vegan
                        </label><br>
                    </div>
                
                    <div class="mt-4">
                        <x-label for="otherDietaryRestrictions" value="Other Dietary Restrictions" />
                        <textarea id="dietaryRestrictions" class="block mt-1 w-full" name="dietary_restrictions[]" rows="3" placeholder="Enter any other dietary restrictions"></textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <x-label for="behavioralNotes" value="Behavioral Notes (optional)" />
                
                    <div class="block mt-1 w-full">
                        <label>
                            <input type="checkbox" name="behavioral_notes[]" value="aggression"> Aggression
                        </label><br>
                        <label>
                            <input type="checkbox" name="behavioral_notes[]" value="anxiety"> Anxiety
                        </label><br>
                        <label>
                            <input type="checkbox" name="behavioral_notes[]" value="fearfulness"> Fearfulness
                        </label><br>
                        <label>
                            <input type="checkbox" name="behavioral_notes[]" value="hyperactivity"> Hyperactivity
                        </label><br>
                        <label>
                            <input type="checkbox" name="behavioral_notes[]" value="house_training_issues"> House Training Issues
                        </label><br>
                        <label>
                            <input type="checkbox" name="behavioral_notes[]" value="leash_training"> Leash Training
                        </label><br>
                        <label>
                            <input type="checkbox" name="behavioral_notes[]" value="separation_anxiety"> Separation Anxiety
                        </label><br>
                    </div>
                
                    <div class="mt-4">
                        <x-label for="otherBehavioralNotes" value="Other Behavioral Notes" />
                        <textarea id="behavioralNotes" class="block mt-1 w-full" name="behavioral_notes[]" rows="3" placeholder="Enter any other behavioral notes"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showPetProfile(petId) {
        document.getElementById('petProfile').classList.add('active');
        
        fetch(`/pets/${petId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('petAvatar').src = `{{ asset('uploads/pets') }}/${data.photo}`;
                document.getElementById('petForm').action = `/pets/${petId}`;
                document.getElementById('pet_name').value = data.pet_name;
                document.getElementById('breed').value = data.breed;
                document.querySelector(`input[name="know_age"][value="${data.know_age}"]`).checked = true;
                
                if (data.know_age === 'yes') {
                    document.getElementById('input-for-yes').style.display = 'block';
                    document.getElementById('input-for-no').style.display = 'none';
                    document.getElementById('age').value = data.exact_age;
                } else {
                    document.getElementById('input-for-yes').style.display = 'none';
                    document.getElementById('input-for-no').style.display = 'block';
                    document.getElementById('estimatedAge').value = data.estimated_age;
                }
                
                document.getElementById('isCastrated').value = data.is_castrated;
                document.getElementById('gender').value = data.gender;
                document.getElementById('weight').value = data.weight;
                document.getElementById('height').value = data.height;

                // Set checkboxes for medical conditions, dietary restrictions, and behavioral notes
                setCheckboxes('medical_conditions', data.medical_conditions);
                setCheckboxes('dietary_restrictions', data.dietary_restrictions);
                setCheckboxes('behavioral_notes', data.behavioral_notes);
            })
            .catch(error => console.error('Error fetching pet details:', error));
    }

    function setCheckboxes(name, values) {
        const checkboxes = document.querySelectorAll(`input[name="${name}[]"]`);
        checkboxes.forEach(checkbox => {
            checkbox.checked = values.includes(checkbox.value);
        });
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('petAvatar');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.querySelectorAll('input[name="know_age"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.value === 'yes') {
                document.getElementById('input-for-yes').style.display = 'block';
                document.getElementById('input-for-no').style.display = 'none';
            } else {
                document.getElementById('input-for-yes').style.display = 'none';
                document.getElementById('input-for-no').style.display = 'block';
            }
        });
    });
</script>

</body>
</html>
