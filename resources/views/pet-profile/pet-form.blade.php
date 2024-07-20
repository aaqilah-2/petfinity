<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>

        /* CSS enhancements */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.image-upload-container {
    position: relative;
    display: inline-block;
}

#petAvatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
}

#petPhoto {
    display: none;
}

.upload-icon {
    position: absolute;
    bottom: 0;
    right: 0;
    border-radius: 50%;
    padding: 5px;
    cursor: pointer;
}

.upload-icon img {
    width: 24px;
    height: 24px;
}

label {
    font-weight: bold;
    color: #555;
}

input[type="text"],
input[type="number"],
input[type="string"],
select,
textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

textarea {
    resize: none;
}

input[type="radio"],
input[type="checkbox"] {
    margin-right: 10px;
}

.toggle-switch {
    display: flex;
    align-items: center;
}

.toggle-switch label {
    margin-right: 10px;
}

.toggle-switch input[type="radio"] {
    display: none;
}

.toggle-switch label {
    cursor: pointer;
}

.toggle-switch-background {
    display: none;
}

.conditional-input {
    display: none;
}

button {
        color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
}
    </style>
</head>
        <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

                <h1>Let's add your furry friend!</h1>

            <form method="POST" action="{{ route('pet.store') }}" enctype="multipart/form-data">
                @csrf


                {{-- profle image section --}}
                <div class="text-center mb-4 image-upload-container">
                    {{-- default value  --}}
                    <img src="{{ asset('images/puppyui.png') }}" alt="Pet Avatar" id="petAvatar">

                    <input type="file" id="petPhoto" name="photo" accept="image/*" onchange="previewImage(event)">
                    <label for="petPhoto" class="upload-icon">
                        <img src="{{ asset('images/images.png') }}" alt="Upload Icon" width="24" height="24">
                    </label>
                </div>

                {{-- pet name section --}}
                <div class="mt-4">
                    <x-label for="pet_name" value="Pet Name" />
                    <x-input id="pet_name" class="block mt-1 w-full" type="text" name="pet_name" placeholder="Enter pet's name" required />
                </div>

                {{-- pet type section ( its hidden cause the input is taken in the previous page) --}}
                <input type="hidden" name="type" value="{{ request('type') }}">

                {{-- pet breed section --}}
                <div class="mt-4">
                    <x-label for="breed" value="Breed" />
                    <x-input id="breed" class="block mt-1 w-full" type="text" name="breed" placeholder="Enter pet's breed" required />
                </div>

                {{-- pet age section including both exact and estimated age fields --}}
                <div class="form-group">
                    <label>Do you know your pet's age?</label>
                    <div class="toggle-switch">
                        <input type="radio" name="know_age" id="toggle-no" value="no" checked>
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

                {{-- is castrated section  --}}
                <div class="mt-4">
                    <x-label for="isCastrated" value="Is Castrated" />
                    <select id="isCastrated" class="block mt-1 w-full" name="is_castrated" required >
                        <option value="not_specified">Not specified</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div> 
                
                {{-- gender section --}}
                <div class="mt-4">
                    <x-label for="gender" value="Gender" />
                    <select id="gender" class="block mt-1 w-full" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                {{-- weight section --}}
                <div class="mt-4">
                    <x-label for="weight" value="Weight (in kg)" />
                    <x-input id="weight" class="block mt-1 w-full" type="number" step="0.1" name="weight" placeholder="Enter pet's weight" required />
                </div>

                {{-- height section --}}
                <div class="mt-4">
                    <x-label for="height" value="Height (in cm)" />
                    <x-input id="height" class="block mt-1 w-full" type="number" step="0.1" name="height" placeholder="Enter pet's height" required />
                </div>

                {{-- medical conditions --}}
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
                        <textarea id="medicalConditions" class="block mt-1 w-full" name="medical_conditions[]" rows="3" placeholder="Enter any other medical conditions" ></textarea>
                    </div>

                </div>

                {{-- dietary restrictions section --}}
                
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
                

                {{-- behavioral notes --}}
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

        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function(){
                    const output = document.getElementById('petAvatar');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
    </x-authentication-card>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleInputs = document.querySelectorAll('.toggle-switch input');
        const inputForNo = document.getElementById('input-for-no');
        const inputForYes = document.getElementById('input-for-yes');

        toggleInputs.forEach(input => {
            input.addEventListener('change', () => {
                if (input.value === 'yes') {
                    inputForNo.style.display = 'none';
                    inputForYes.style.display = 'block';
                } else {
                    inputForNo.style.display = 'block';
                    inputForYes.style.display = 'none';
                }
            });
        });
    });
</script>

{{-- java script part for medical conditions field  --}}
<script>
    function toggleOtherField(value) {
        var otherField = document.getElementById('otherField');
        if (value === 'other') {
            otherField.style.display = 'block';
        } else {
            otherField.style.display = 'none';
        }
    }
</script>


</body>
</html>
