<p>Atualmente, você possui {{ sizeof($proposals) == 0 ? "nenhuma" : sizeof($proposals) }} {{ sizeof($proposals) < 2 ? "proposta" : "propostas" }} de estágio.</p>
<p>Destas propostas, {{ sizeof($proposalsInProgress) == 0 ? "nenhuma" : sizeof($proposalsInProgress) }} {{ sizeof($proposalsInProgress) < 2 ? "está aprovada" : "estão aprovadas" }}</p>


