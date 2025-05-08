   <!-- resources/views/components/recommended-calculators.blade.php -->
   <div class="py-4 px-2">
       <h2 class="text-xl font-bold mb-4">Explore Other Calculators</h2>
       <ul id="recommendedCalculators" class="list-disc pl-5">
           <!-- Recommended calculators will be inserted here by JavaScript -->
       </ul>
   </div>

   <script>
   document.addEventListener('DOMContentLoaded', function() {
       fetch('/api/recommended-calculators')
           .then(response => response.json())
           .then(calculators => {
               const list = document.getElementById('recommendedCalculators');
               calculators.forEach(calculator => {
                   const listItem = document.createElement('li');
                   listItem.innerHTML = `<a href="${calculator.url}" class="text-blue-500 underline">${calculator.name}</a> - ${calculator.description}`;
                   list.appendChild(listItem);
               });
           })
           .catch(error => console.error('Error fetching calculators:', error));
   });
   </script>