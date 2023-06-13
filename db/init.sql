CREATE TABLE users (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL,
  email TEXT NOT NULL,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT)
);

  INSERT INTO
  users (id, name, email, username, password)
VALUES
  (
    1,
    'Esther Han',
    'eyh25@cornell.edu',
    'esther',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.' -- monkey
  );

  INSERT INTO
  users (id, name, email, username, password)
VALUES
  (
    2,
    'Nicole Choi',
    'nhc35@cornell.edu',
    'nicole',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.' -- monkey
  );

CREATE TABLE sessions (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE groups (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL UNIQUE,
  PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
  groups (id, name)
VALUES
  (1, 'admin');

--- Group Membership ---
CREATE TABLE user_groups (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  group_id INTEGER NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(group_id) REFERENCES groups(id),
  FOREIGN KEY(user_id) REFERENCES users(id)
);

-- User 'esther' is a member of the 'admin' group.
INSERT INTO
  user_groups (user_id, group_id)
VALUES
  (1, 1);


CREATE TABLE location_tags (
id INTEGER NOT NULL UNIQUE,
location_id INTEGER NOT NULL,
tag_id INTEGER NOT NULL,
PRIMARY KEY(id AUTOINCREMENT),
FOREIGN KEY (location_id) REFERENCES locations(id),
FOREIGN KEY (tag_id) REFERENCES tags(id)
);

INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    1,
    1,
    1
  );

INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    2,
    2,
    1
  );

INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    3,
    3,
    2
  );

INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    4,
    3,
    3
  );

  INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    5,
    4,
    1
  );

  INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    6,
    5,
    1
  );

  INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    7,
    5,
    4
  );

INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    8,
    6,
    4
  );



  INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    9,
    7,
    2
  );

INSERT INTO
  location_tags (id, location_id, tag_id)
VALUES
  (
    10,
    7,
    3
  );

CREATE TABLE locations (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL,
  address TEXT,
  description TEXT NOT NULL,
  file_name TEXT NOT NULL,
  file_ext TEXT NOT NULL,
  source TEXT,
  PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
  locations (id, name, address, description, file_name, file_ext, source)
VALUES
  (
    1,
    'Duffield Atrium',
    '343 Campus Rd, Ithaca, NY 14853',
    "The atrium's natural light and comfortable seating arrangements make it an ideal place for students to focus on their studies or collaborate with peers. With its central location on campus, the Duffield Atrium is easily accessible, and its serene ambiance provides a welcome escape from the hustle and bustle of campus life. Whether you're looking for a quiet place to study or a spot to work on group projects, the Duffield Atrium is a great option for Cornell students.",
    'DUFFILELD.png',
    'png',
    'https://www.engineering.cornell.edu/tour-duffield-hall'
  );

INSERT INTO
  locations (id, name, address, description, file_name, file_ext, source)
VALUES
  (
    2,
    'Olin Library Basement',
    '161 Ho Plaza, Ithaca, NY 14853',
    "The Olin Library Basement at Cornell University is a great study spot for both individuals and groups. Unlike other quiet study spaces on campus, the basement offers a more relaxed atmosphere that is suitable for collaboration and discussion. Equipped ample table space, it's a great spot for group projects or studying with friends. Additionally, the basement is open until midnight, making it a convenient option for evening study sessions. Although it may not be the best place for individual, quiet study, it's definitely worth considering if you're looking for a more relaxed environment that still offers a productive atmosphere.",
    'OLIN.png',
    'png',
    'https://onmogul.com/stories/favorite-studying-places-1-olin-library'
    );

INSERT INTO
  locations (id, name, description, file_name, file_ext, source)
VALUES
  (
    3,
    'Beebe Lake',
    "Beebe Lake, situated in the heart of Cornell University, is a charming and romantic destination that's perfect for a special date. With its stunning natural beauty and serene atmosphere, it's an ideal spot for a romantic picnic or a leisurely stroll with a loved one. Its tranquil surroundings and picturesque views make for an unforgettable setting that's sure to impress.",
    'BEEBE.png',
    'png',
    'https://viewsinfinitum.com/2011/10/31/view-201-beebe-lake-at-cornell-university/'
  );

  INSERT INTO
  locations (id, name, address, description, file_name, file_ext, source)
VALUES
  (
    4,
    'Upson Hall',
    '124 Hoy Rd, Ithaca, NY 14850',
    "Upson Hall at Cornell University is a great study space for students. The building features several study lounges, classrooms, and seminar rooms that provide a quiet and focused environment for students to study and work on group projects. Its central location on the engineering quad provides easy access to other academic buildings and resources, including the engineering library. Upson Hall is equipped with high-speed internet and printing resources, making it easy for students to access and print study materials. Additionally, students can take advantage of the building's state-of-the-art research facilities for unique opportunities to engage in cutting-edge research in their respective fields. Overall, Upson Hall is an ideal location for students to engage in focused study and collaboration with peers..",
    "UPSON.jpeg",
    'jpeg',
    'https://www.lumenarch.com/projects/cornell-upson-hall'
  );

  INSERT INTO
  locations (id, name, address, description, file_name, file_ext, source)
VALUES
  (
    5,
    'Sage Hall',
    '114 E Ave, Ithaca, NY 14853',
    "Sage Hall at Cornell University is a popular study space for students in the Johnson Graduate School of Management. The building features several study lounges and classrooms that provide a quiet and focused environment for students to study and work on group projects. Its central location on the main campus provides easy access to other academic buildings and resources. The building's café is also a popular spot for students to grab a quick bite to eat or a coffee before settling in for a study session. Sage Hall is equipped with high-speed internet and printing resources, making it easy for students to access and print study materials.",
    'SAGE.jpeg',
    'jpeg',
    'https://www.johnson.cornell.edu/about/campus-virtual-tour/'
  );

INSERT INTO
  locations (id, name, address, description, file_name, file_ext, source)
VALUES
  (
    6,
    'Novicks Cafe',
    '155 Program House Dr, Ithaca, NY 14850',
    "Novack's Café is a popular coffee shop located in the center of Cornell University's campus. The café offers a cozy atmosphere with ample seating for students to study, work on group projects, or catch up with friends. Its central location makes it an ideal meeting spot for students before or after classes.

    Novack's Café serves a variety of coffee and tea options, as well as light snacks and pastries. The café is known for its delicious coffee and friendly service, making it a favorite spot for many Cornell students. Novack's also provides high-speed internet and printing resources, making it easy for students to access and print study materials as needed.

    Overall, Novack's Café is a great study spot for students at Cornell University. Its cozy atmosphere, delicious coffee, and convenient location make it an ideal place for students to study and socialize.",
    'NOVICKS.jpeg',
    'jpeg',
    'https://ncre.cornell.edu/node/311'
  );

  INSERT INTO
  locations (id, name, description, file_name, file_ext, source)
VALUES
  (
    7,
    'Cascadilla Trail',
    "Cascadilla Gorge Trail is a picturesque nature spot located on the campus of Cornell University, making it an ideal location for a date or casual outing. The trail offers a beautiful and scenic hike through a gorge that features several waterfalls and natural rock formations. The trail is accessible year-round, but it is especially beautiful in the spring and fall.

    The trailhead is located near several campus buildings, making it an easy and convenient spot to access. The trail is not overly strenuous and is suitable for all levels of hikers. It is a great way to get outside and enjoy nature without having to leave campus.

    Along the trail, there are several benches and picnic areas, providing opportunities for a romantic picnic or a casual snack break. The natural beauty of the trail also offers great photo opportunities for couples looking to capture a special moment.

    Overall, Cascadilla Gorge Trail is an excellent option for a date or casual outing on the Cornell University campus. Its natural beauty, convenient location, and accessibility make it a great place to enjoy the outdoors and spend quality time with a loved one.",
    'CASC.jpeg',
    'jpeg',
    'https://uncoveringnewyork.com/cascadilla-gorge-ithaca/'
  );

CREATE TABLE tags (
  id INTEGER NOT NULL UNIQUE,
  tag TEXT,
  PRIMARY KEY(id AUTOINCREMENT)
);

INSERT INTO
  tags (id, tag)
VALUES
  (
    1,
    'Study Spot'
  );

INSERT INTO
  tags (id, tag)
VALUES
  (
    2,
    'Date Spot'
  );

INSERT INTO
  tags (id, tag)
VALUES
  (
    3,
    'Nature Spot'
  );

  INSERT INTO
  tags (id, tag)
VALUES
  (
    4,
    'Food Spot'
  );
