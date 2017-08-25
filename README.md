# ipl-scheduling-using-round-robin-algo
IPL Schedule Generator in PHP

IPL (Indian Premier League) is a popular cricket tournament.<br/>
Total 8 teams participate in the tournament Lets say Team A - Team H. Each team belongs to a different city. Each team is supposed to play with the other team twice.<br/>
For example Team A has to play with Team C, twice, but once in the city which Team A represents and once in the city which Team C represents.

Write an algorithm to schedule matches for the entire tournament given the following.


1. For example Team A has to play with Team C, twice, but once in the city which Team A represents and once in the city which Team C represents.
2. A team cannot play matches on two consecutive days.
<3. Every day only one match can be played, except on week ends (Saturday and Sunday) two games can be played.


The program should accept the start day of the tournament, and create a fixture table which ensures the conditions are met.  The Fixture table must contain the following as columns

Match #, Date, Team Names (Team A Vs Team C), City.
