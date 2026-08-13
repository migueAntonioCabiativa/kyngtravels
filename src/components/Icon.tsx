import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import type { IconDefinition } from "@fortawesome/fontawesome-svg-core";
import styles from "../styles/Icon.module.css";

interface Props {
  icon: IconDefinition;
  className?: string;
}

export default function Icon({ icon, className }: Props) {
  const moduleClass = className && (styles as Record<string, string>)[className]
    ? (styles as Record<string, string>)[className]
    : className;

  return <FontAwesomeIcon icon={icon} className={`${styles["icon-inner"]} ${moduleClass || ""}`} />;
}
